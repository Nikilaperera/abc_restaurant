<?php

class Financeapi extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function finance_url(){
        $finance_url = "https://entutionclient.entution.com/BileetaIntegrationabc_restaurantWebAPI/";
        return $finance_url;
    }

}
