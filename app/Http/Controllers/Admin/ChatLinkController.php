<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatGuestLink;
use Illuminate\Support\Str;
use File;

class ChatLinkController extends Controller
{
    // ১. সব লিংকের লিস্ট দেখানো
    public function index()
    {
        $links = ChatGuestLink::latest()->get();
        return view('backend.chat_links.index', compact('links'));
    }

    // ২. নতুন লিংক জেনারেট এবং ইমেজ প্রসেসিং
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'subtitle' => 'nullable|string|max:50', // নতুন ইনপুট
            'country' => 'nullable|string|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // ১০ এমবি পর্যন্ত এলাউড
        ]);

        // ইমেজ ফোল্ডার পাথ
        $destinationPath = public_path('uploads/guest_avatars');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0775, true);
        }

        // ইউনিক নাম তৈরি
        $imageName = time() . '.png';
        $fullPath = $destinationPath . '/' . $imageName;

        // ইমেজ রিসাইজ এবং কম্প্রেশন (১৫০x১৫০ পিক্সেল - সুপার লাইটওয়েট)
        $this->processAndCompressImage($request->file('image'), $fullPath);

        // ডাটাবেস সেভ
        $avatarPath = 'uploads/guest_avatars/' . $imageName;
        $virtualPhone = '+999' . now()->getTimestamp() . rand(100, 999);
        $token = Str::random(40);

        $linkData = ChatGuestLink::create([
            'name' => $request->name,
            'subtitle' => $request->subtitle, // ডাটাবেসে সেভ হচ্ছে
            'country' => $request->country, 
            'avatar' => $avatarPath,
            'virtual_number' => $virtualPhone,
            'token' => $token,
        ]);

        // [PRE-SYNC] চ্যাট সার্ভারকে ব্যাকগ্রাউন্ডে ছবিটা ডাউনলোড করতে বলা
        // যাতে ইউজার লিংকে ক্লিক করার আগেই চ্যাট সার্ভারে ছবি রেডি থাকে
        try {
            $avatarUrl = asset($avatarPath);
            // চ্যাট অ্যাপের demologin হিট করা হচ্ছে (pages ফোল্ডারে থাকলে .php লাগবে না)
            $syncUrl = "https://chat.probasipay.com/demologin?name=" . urlencode($request->name) . "&number=" . urlencode($virtualPhone) . "&profile=" . urlencode($avatarUrl);
            
            // সাইলেন্টলি হিট করার জন্য (Timeout ১ সেকেন্ড দেওয়া হয়েছে যাতে এডমিন প্যানেল স্লো না হয়)
            $ctx = stream_context_create(['http' => ['timeout' => 1]]);
            @file_get_contents($syncUrl, false, $ctx);
        } catch (\Exception $e) {
            // এরর হলে ইগনোর করবে
        }

        return back()->with('success', 'Identity Created & Image Synced Successfully!');
    }

    // ৩. লিংক ডিলিট করা
    public function destroy($id)
    {
        $link = ChatGuestLink::findOrFail($id);
        
        // ফাইল ডিলিট
        if (File::exists(public_path($link->avatar))) {
            File::delete(public_path($link->avatar));
        }
        
        $link->delete();
        return back()->with('success', 'Identity Removed!');
    }

    // ৪. লিংকে ক্লিক করলে চ্যাট অ্যাপে রিডাইরেক্ট
    public function joinChat($token)
    {
        $guest = ChatGuestLink::where('token', $token)->first();

        if (!$guest) {
            abort(404, 'Link Expired or Invalid');
        }

        $chatBaseUrl = "https://chat.probasipay.com/demologin";

        $query = http_build_query([
            'name' => $guest->name,
            'number' => $guest->virtual_number,
            'profile' => asset($guest->avatar)
        ]);

        return redirect($chatBaseUrl . '?' . $query);
    }

    /**
     * ইমেজ রিসাইজ এবং কম্প্রেশন হেল্পার (Pure PHP GD)
     */
    private function processAndCompressImage($file, $destination)
    {
        $sourcePath = $file->getRealPath();
        $info = getimagesize($sourcePath);
        
        // ইমেজ টাইপ অনুযায়ী রিসোর্স তৈরি
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($sourcePath);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($sourcePath);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($sourcePath);
        else $image = imagecreatefromjpeg($sourcePath);

        $width = 150;
        $height = 150;
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        // নতুন ক্যানভাস
        $newImage = imagecreatetruecolor($width, $height);

        // ট্রান্সপারেন্সি হ্যান্ডলিং
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);

        // রিসাইজ করা
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

        // সেভ করা (PNG 8 মানে হাই কম্প্রেশন)
        imagepng($newImage, $destination, 8);
        
        imagedestroy($image);
        imagedestroy($newImage);
    }
    
   public function toggleStatus(Request $request)
{
    $link = \App\Models\ChatGuestLink::findOrFail($request->id);
    $newStatus = $link->is_online == 1 ? 0 : 1;
    $link->update(['is_online' => $newStatus]);

    try {
        $pdo = new \PDO("mysql:host=localhost;dbname=probasip_group;charset=utf8mb4", "probasip_group", "oM}dA[3f$)AU");
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
        // ১. আগে ইউজার আইডি খুঁজে বের করা
        $uStmt = $pdo->prepare("SELECT user_id FROM gr_site_users WHERE phone_number = ? LIMIT 1");
        $uStmt->execute([$link->virtual_number]);
        $user = $uStmt->fetch();

        if ($user) {
            $userId = $user['user_id'];

            if ($newStatus == 0) {
                // [CRITICAL FIX] যদি অফলাইন করি, তবে সেশন টেবিল থেকে সব ডিলিট করে দিতে হবে
                // যাতে চ্যাট অ্যাপের অটো-অনলাইন সিস্টেম তাকে আর খুঁজে না পায়
                $pdo->prepare("DELETE FROM gr_login_sessions WHERE user_id = ?")->execute([$userId]);
                
                $onlineVal = 0;
                $lastSeen = date('Y-m-d H:i:s', strtotime('-1 hour')); // ১ ঘণ্টা আগের সময় (অফলাইন নিশ্চিত করতে)
            } else {
                $onlineVal = 1;
                $lastSeen = date('Y-m-d H:i:s', strtotime('+2 hours')); // ২ ঘণ্টা পরের সময়
            }

            // ২. স্ট্যাটাস এবং লাস্ট সিন আপডেট
            $stmt = $pdo->prepare("UPDATE gr_site_users SET online_status = ?, last_seen_on = ? WHERE user_id = ?");
            $stmt->execute([$onlineVal, $lastSeen, $userId]);
        }

    } catch (\Exception $e) {
        \Log::error("Chat DB Sync Error: " . $e->getMessage());
    }

    return response()->json(['success' => true]);
}
}