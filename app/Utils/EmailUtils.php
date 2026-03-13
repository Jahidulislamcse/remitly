<?php
namespace App\Utils ;

use App\Models\EmailTemplate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SiteSettings;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;

class EmailUtils {

    public function emailbody($data,$type=''){

        if($type){
            $template = @EmailTemplate::where('cat',$type)->first()->content ;
        }else{
            $template = @$data['message'] ;
        }

        $user = User::where('id',@$data['client_id'])->first() ;
        $reset_url = route('forget-password',@$user->remember_token ? : '').'?id='.@$user->id ;
        $verification_url = route('email-varify',@$user->remember_token ? : '' ).'?id='.@$user->id ;

        $trans = Transaction::find(@$data['trans_id']) ;
        $trans_amount = @$trans->amount ;
        $trans_tnx_code = @$trans->tnx_code ;
        $trans_payment_method = @$trans->payment_method ;

        $site_settings = SiteSettings::first() ;
        $signature = '<img src="'.asset(@$site_settings->site_logo).'" height="50px" />' ;
        $company_name = @$site_settings->site_title;
        $company_address = @$site_settings->site_address;
        $company_phone = @$site_settings->site_phone;

        $order = Order::where('id',@$data['order_id'])->first();
        $order_number = @$order->order_code ;
        $order_details = view('backend.order.invoice',compact('order'))->render() ;

        $orderitem = OrderItem::where('id',@$data['orderitem_id'])->first();
        $orderitem_ip = @$orderitem->ip ;
        $orderitem_login = @$orderitem->login ;
        $orderitem_password = @$orderitem->pssword ;


        $support_ticket = SupportTicket::find(@$data['support_id']);
        $support_code = @$support_ticket->code ;
        $support_details = @$support_ticket->details ;
        $support_reply = @$support_ticket->reply  ;
        

        $find = ['$client_name','$client_balance','$client_address','$client_phone','$signature','$company_name','$company_address','$company_phone','$order_details','$order_number','$reset_url','$verification_url','$trans_amount','$trans_tnx_code','$trans_payment_method','$support_code','$support_details','$support_reply','$orderitem_ip','$orderitem_login','$orderitem_password']  ;
        $replace = [@$user->name,@$user->balance,@$user->address,@$user->phone,@$signature,@$company_name,@$company_address,@$company_phone,@$order_details,@$order_number,@$reset_url,@$verification_url,@$trans_amount,@$trans_tnx_code,@$trans_payment_method,@$support_code,@$support_details,@$support_reply,@$orderitem_ip,@$orderitem_login,@$orderitem_password] ;

        $template = str_replace($find,$replace,$template);
        return $template ;

       

    }

    public function emailsubject($type=''){
        $template = @EmailTemplate::where('cat',$type)->first()->title ;
        return $template ;
    }

}