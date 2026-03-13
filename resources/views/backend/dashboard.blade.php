@extends('backend.layout.master')
@section('meta')
    <link rel="canonical" href="{{ route('user.index') }}" />
@endsection
@section('style')
<style>
    body{
        background-color: #356567;
    }
    .tf-balance-box {
        background-color: #356567;
    }
</style>
@endsection

@section('content')
    @if (auth()->user()->agree == 0)
        @php $content = App\Models\Section::where('key','agreement')->first(); @endphp
        <div style="padding:30px;" >
            <div style="text-align: center; border-bottom:1px solid #000; color:#000;">
                <span style="font-size:18px ; font-weight:600; text-align:center; color:#000;">
                    অঙ্গীকার নামা/ চুক্তিপত্র <br> {{ siteInfo()->company_name }}    <br>
                </span>
                    ৯ ইশ্বরচন্দ্রশীল বাহাদুর রোড, নলগলা, মিটফোর্ড <br> রোড, ঢাকা-১১০০

            </div>

            <br>
           <p style="font-size: 14px; line-height: 1.6; font-family: 'Arial', sans-serif; color:#000;">
            আমি {{ auth()->user()->name }} পেশা: প্রবাসী। জাতীয়তা: বাংলাদেশি। বর্তমানে
            আমি {{ auth()->user()->name }}, {{ @$country->name }} এ অবস্থানরত। {{ siteInfo()->company_name }}. এর অ্যাপস ব্যবহারের জন্য এই মর্মে অঙ্গীকার করিতেছি যে গ্রাহকের অর্থের সম্পূর্ণ নিরাপত্তা দেওয়ার দায়িত্ব গ্লোবাল রেমিটেন্স সার্ভিস লি. এর। গ্রাহকের যেকোন সমস্যার জন্য গ্লোবাল রেমিটেন্স সার্ভিস লি. দায়বদ্ধ থাকিবে। এবং যেকোন সময় যেকোন সমস্যার সহায়তা গ্লোবাল রেমিটেন্স সার্ভিস লি. করিবে বলে থাকে। এই অঙ্গীকারপত্র যার কাছে থাকিবে না, সে কখনই গ্লোবাল রেমিটেন্স সার্ভিস লি. এর কাছে প্রশ্ন বা দায়বদ্ধতা দাবী করিতে পারিবে না। কোম্পানি আইন ১৯৯৪ ধারা অনুসারে সকল দায়বদ্ধতা গ্লোবাল রেমিটেন্স সার্ভিস লি. গ্রহণ করিবে। গ্লোবাল রেমিটেন্স সার্ভিস লি. এর কিছু শর্ত মেনে গ্রাহককে লেনদেন করিতে হইবে। শর্তসমূহ হল।
            <br>
            ১। গ্রাহকের অ্যাকাউন্ট ব্যবহার করে অন্যকেও লেনদেন করলে গ্লোবাল রেমিটেন্স সার্ভিস লি. সেক্ষেত্রে কোন দায়বদ্ধতা গ্রহণ করিবে না।
            <br>
            <br>
            ২। ১ লক্ষ টাকার অধিক যদি হয়ে থাকে তাহলেই অবশ্যই সেটা ব্যাংকে লেনদেন করবে, ১ লক্ষ টাকার নিচে যেকোন অর্থ ব্যাংকে লেনদেন করা হইবে না এটা সম্পূর্ণরূপে বিকাশ রকেট ও নগদে লেনদেন করা হইবে।
            <br>
            <br>
            ৩। বিকাশে, নগদে, রকেটে, টাকা লেনদেন করার সময় অবশ্যই ট্রানজেকশন আইডি ও পিন এজেন্টকে দিতে হবে।
            <br>
            <br>
            ৪। ইন্টারন্যাশনাল ডলার, দিনার, রিয়াল, রিঙ্গিত, দিরহাম ইত্যাদি মুদ্রার দাম কম বাড়ার সাথে গ্রাহকের অর্থ কম বা বেশি হইতে পারে তা মেনে নিতে হবে।
           </p>
        </p>

            {{-- {!! @$content->value !!} --}}
        </div>
        <div class="text-center mb-3">
            <a class="btn btn-primary" href="{{ route('register.agree') }}">সম্মতি দিচ্ছি</a>
        </div>
    @else
        @if (auth()->user()->status == 0)
            <div class="alert alert-danger text-center mt-5" role="alert">
                <strong style="font-size: 18px;" class="px-4">সম্মানিত গ্রাহক আপনার একাউন্ট এক্টিভ করে নিতে নিচের দেওয়া হোয়াটসঅ্যাপে যোগাযোগ করুন</strong>
                <br>
		
                 <a aria-label="Chat on WhatsApp" href="https://wa.me/+13194321520"> <img style="width: 50%" alt="Chat on WhatsApp" src="{{ asset('frontend/whatsapp-bt.gif')}}" /></a>
            </div>

            <p style="font-size: 18px;" class="px-4"> ক্লিক করে Whatsapp এ গিয়ে ম্যাসেজ বা কল দিন </p>

           
        @else
            @if (auth()->user()->role == 'digital-marketing')
                @include('admin.apuser')
            @endif

            @if (auth()->user()->role == 'ap')
                @include('admin.apuser')
            @endif

            @if (auth()->user()->role == 'admin')
                @include('admin.aduser')
            @endif
        @endif

    @endif
@endsection


@section('script')
  <script>

  fetchNotification();
        async function fetchNotification() {
            try {
                const response = await fetch('/get-random-notification');
                const data = await response.json();
                if (data.message) {

                        const now = new Date();
                        const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        $('.notify').html(data.message + ' | ' + time);


                }else{
                    $('.notify').html('No notification found!')
                }
            } catch (err) {
                console.error('Failed to fetch notification:', err);
            }
        }
        setInterval(fetchNotification, 10000);
    </script>
@endsection