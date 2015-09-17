<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function data_submitted() {
		$data = array(
		'apparel_type' => $this->input->post('shirts'),
		'quantity' => $this->input->post('quantity'),
		'front_colors' => $this->input->post('front_colors'),
		'back_colors' => $this->input->post('back_colors')
		);
		
		//Take care of invalid parameter values
		if($data['quantity'] <= 0 || $data['front_colors'] < 0 || $data['back_colors'] < 0
		|| $data['front_colors'] > 6 || $data['back_colors'] > 6)
		{
			$results = array(
        	'error' => "Invalid value(s)!!"
        	);
        	$this->load->view("welcome_message", $results);
        	return;
        }
        
        //Extract data from database
		$this->load->database();
		$sql = 'SELECT Price_White, Price_Color, Shipping FROM freshprints.Apparel_Data WHERE Garment = ?';
		$query = $this->db->query($sql, array($data['apparel_type']));
		
		$price_white = "0";
        $price_color = "0";
        $shipping = "0";
		foreach ($query->result() as $row)
		{
        	$price_white = $row->Price_White;
        	$price_color = $row->Price_Color;
        	$shipping =  $row->Shipping;
		}
		
		$front_price = "0";
		$back_price = "0";
		
		if(doubleval($data['front_colors']) > 0 && doubleval($data['back_colors']) > 0) {
			$sql = 'SELECT ?_ FROM freshprints.Printer_Pricing WHERE Pricing_List < ?
            	Order by Pricing_List DESC LIMIT 1';
    		$query = $this->db->query($sql, array(intval($data['front_colors']), $data['quantity']));
    	
    	
        	foreach ($query->result_array() as $row)
			{
				
				$front_price = $row["{$data['front_colors']}_"];
			}
		
			$sql = 'SELECT ?_ FROM freshprints.Printer_Pricing WHERE Pricing_List < ?
        	    	Order by Pricing_List DESC LIMIT 1';
    		$query = $this->db->query($sql, array(intval($data['back_colors']), $data['quantity']));
    	
        	foreach ($query->result_array() as $row)
			{
				
        		$back_price = $row["{$data['back_colors']}_"];;
			}
		}
		
		//Do calculation
		$total_price = 0.00;
        $CostPerItem = 0.00;
        $compensation = 0.00;
        
        if(doubleval($data['front_colors']) == 0 && doubleval($data['back_colors']) == 0)
        {
            $CostPerItem =  doubleval($price_white);
        }
        else 
        {
            $CostPerItem = doubleval($price_color)
                        + (doubleval($front_price) + doubleval($back_price));
        }
        if($shipping == '1') {
                if(intval($data['quantity']) < 48) {
                	
                    $CostPerItem += doubleval(1);
                }
                else {
                	
                    $CostPerItem += doubleval(0.75);
                }
        }
        else {
                if(intval($data['quantity']) < 48) {
                    $CostPerItem +=  doubleval(0.5);
                }
                else {
                    $CostPerItem +=  doubleval(0.25);
                }
    	}
        $total_price = doubleval($data['quantity']) * $CostPerItem;
        $compensation = 0.07 * $total_price;
        if($total_price <= 800)
            $total_price = (0.5 * $total_price) + $total_price;
        else
             $total_price = (0.45 * $total_price) + $total_price;
             
        $results = array(
        'total_price' => $total_price, 
        'quantity' => $data['quantity']
        );
        $this->load->view("welcome_message", $results);
	}	
}