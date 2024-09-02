<?php


defined('BASEPATH') or exit('No direct script access allowed');

class MemberSubscription extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MemberSubscriptionMod');
        $this->load->model('Ion_auth_model');
        $this->load->database();

        $this->load->library('ion_auth');
        $this->load->library('api_auth');
        $this->load->library('email');
        $this->load->library(['system_log']);

    }

    public function index(){
        print_r("1212");
        die();
    }

    public function subscription($password){

        if($password == 232372334923432323232343443){

            print_r("stop");
            die();
            //get member data
            $members=$this->MemberSubscriptionMod->getValueAll("tbl_member_info","*","WHERE tbl_member_info.subscription=0 AND tbl_member_info.membership_category='SMA'",null,null,null,"ORDER BY id DESC LIMIT 10000");

            foreach ($members as $member){

                //get last subscription amount
                if($subscription=$this->MemberSubscriptionMod->getValueOne("tbl_payment_member_subscription","*","WHERE tbl_payment_member_subscription.subscription=0 AND tbl_payment_member_subscription.member_category='SMA' AND member_id='".$member->member_id."'",null,null,null,"ORDER BY year DESC LIMIT 1")) {

                    if ($subscription->year < 2023) {
                        //get current year
                        $year = $subscription->year + 1;
                        for($year;$year <= 2023;$year++){

                            //get subscription amount
                            $membership_rate=$this->MemberSubscriptionMod->getValueOne("tbl_master_membership_category_rates","*","WHERE year='".$year."'",null,null,null,null);

                            //get subscription amount
                            $payment_key = $this->Ion_auth_model->hash_password(rand(100000, 1000000));
                            $payment_key = str_replace('/', '', $payment_key);
                            $payment_key = str_replace('$', '', $payment_key);

                            $subscription_fee = 0;
                            $late_subscription_fee = 0;

                            if($year <= 2007){
                                $subscription_fee = $membership_rate->subcription_fee*0.5;
                                $late_subscription_fee = $membership_rate->late_subscription_fee*0.5;
                            }
                            else{
                                $subscription_fee = $membership_rate->subcription_fee;
                                $late_subscription_fee = $membership_rate->late_subscription_fee;
                            }

                            $data=array(
                                'payment_key'=>$payment_key,
                                'member_category'=>$member->membership_category,
                                'nic'=>$member->nic,
                                'member_id'=>$member->member_id,
                                'year'=>$year,
                                'subscription_fee'=>$subscription_fee,
                                'late_subscription_fee'=>0,
                                'surcharge_fee'=>$late_subscription_fee,
                                'total_amount'=>$subscription_fee,
                                'due_date'=>$year."-12-31",
                                'paid_status'=>'Pending'
                            );

                            $insert_subscription = $this->MemberSubscriptionMod->save('tbl_payment_member_subscription',$data);

                            $data_update2 = array(
                                'subscription'=>1
                            );

                            $this->MemberSubscriptionMod->update('tbl_payment_member_subscription',$data_update2,array('member_id'=>$member->member_id));
                            $this->MemberSubscriptionMod->update('tbl_member_info',$data_update2,array('member_id'=>$member->member_id));

                        }
                    }
                    else{

                        $data_update2 = array(
                            'subscription'=>2
                        );

                        $this->MemberSubscriptionMod->update('tbl_payment_member_subscription',$data_update2,array('member_id'=>$member->member_id));
                        $this->MemberSubscriptionMod->update('tbl_member_info',$data_update2,array('member_id'=>$member->member_id));
                    }
                }
                else{

                    $data_update2 = array(
                        'subscription'=>2
                    );

                    $this->MemberSubscriptionMod->update('tbl_payment_member_subscription',$data_update2,array('member_id'=>$member->member_id));
                    $this->MemberSubscriptionMod->update('tbl_member_info',$data_update2,array('member_id'=>$member->member_id));

                }
            }

            echo json_encode(array("status"=>true));
        }
    }

    public function generate_subscription(){

        $temp_subscriptions=$this->MemberSubscriptionMod->getValueAll("tbl_temp_subscription","*","WHERE tbl_temp_subscription.status=0",null,null,null,"ORDER BY id DESC LIMIT 10000");

        foreach ($temp_subscriptions as $subs){

            $member=$this->MemberSubscriptionMod->getValueOne("tbl_member_info","*","WHERE tbl_member_info.member_id='".$subs->member_id."'",null,null,null,null);

            //get subscription amount
            $payment_key = $this->Ion_auth_model->hash_password(rand(100000, 1000000));
            $payment_key = str_replace('/', '', $payment_key);
            $payment_key = str_replace('$', '', $payment_key);

            $data=array(
                'payment_key'=>$payment_key,
                'member_category'=>$member->membership_category,
                'nic'=>$member->nic,
                'member_id'=>$member->member_id,
                'year'=>'2023',
                'subscription_fee'=>$subs->amount,
                'late_subscription_fee'=>0,
                'surcharge_fee'=>$subs->amount*1.1,
                'total_amount'=>$subs->amount,
                'due_date'=>'2022'."-12-31",
                'paid_status'=>'Pending'
            );

            $insert_subscription = $this->MemberSubscriptionMod->save('tbl_payment_member_subscription',$data);

            $data_update2 = array(
                'status'=>1
            );

            $this->MemberSubscriptionMod->update('tbl_temp_subscription',$data_update2,array('member_id'=>$member->member_id));

        }

        echo json_encode(array("status"=>true));

    }

    public function generate_subscription_member(){

        $members=$this->MemberSubscriptionMod->getValueAll("tbl_member_info","*","WHERE tbl_member_info.status='Active' AND tbl_member_info.subscription=0 AND tbl_member_info.membership_category='SMA'",null,null,null,"ORDER BY id DESC LIMIT 8000");

        foreach ($members as $member){


            //get subscription amount
            $payment_key = $this->Ion_auth_model->hash_password(rand(100000, 1000000));
            $payment_key = str_replace('/', '', $payment_key);
            $payment_key = str_replace('$', '', $payment_key);

            $data=array(
                'payment_key'=>$payment_key,
                'member_category'=>$member->membership_category,
                'nic'=>$member->nic,
                'member_id'=>$member->member_id,
                'year'=>'2023',
                'subscription_fee'=>2400,
                'late_subscription_fee'=>0,
                'surcharge_fee'=>2400,
                'total_amount'=>2640,
                'due_date'=>'2023'."-12-31",
                'paid_status'=>'Pending'
            );

            $insert_subscription = $this->MemberSubscriptionMod->save('tbl_payment_member_subscription',$data);

            $data_update2 = array(
                'subscription'=>1
            );

            $this->MemberSubscriptionMod->update('tbl_member_info',$data_update2,array('member_id'=>$member->member_id));
        }

        echo json_encode(array("status"=>true));

    }

}
