<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

require_once 'src/escrow/api.php';

use Escrow\Api;

$config = array(
    'username'     => 'exmaple@example.com',
    'seller_email' => 'seller@example.com',
    'password'     => 'mypassword',
    'partner_id'   => '1234',
);

// Note: Be sure to set the API URL as 3rd param for production
$api = new Api($config['username'], $config['password']);

// Example of how to create a new transaction
$transaction = $api->createTransaction(array(
    "Title"                      => "Test General Merchandise Title",
    "Description"                => "Description",
    "TransactionType"            => "1",
    "Partner"                    => array(
        "PartnerId" => $config['partner_id'],
    ),
    "Buyer"                      => array(
        "Email"            => "buyeremail@example.com",
        "Initiator"        => "false",
        "CompanyChk"       => "false",
        "AutoAgree"        => "false",
        "AgreementChecked" => "false"
    ),
    "Seller"                     => array(
        "Email"            => $config['seller_email'],
        "Initiator"        => "true",
        "CompanyChk"       => "false",
        "AutoAgree"        => "false",
        "AgreementChecked" => "false"
    ),
    "LineItems"                  => array(array(
        "ItemName"    => "Line Item 1",
        "Description" => "Line Item 1 Description",
        "Quantity"    => "1",
        "Price"       => "2500",
        "Accept"      => "true",
        "SellComm"    => "100",
        "BuyComm"     => "50"
    )),
    "EscrowPayment"              => "0",
    "ShipmentFee"                => "25",
    "ShipmentPayment"            => "0",
    "InspectionLength"           => "6",
    "Currency"                   => "USD",
    "Fulfillment"                => "2",
    "CommissionType"             => "1",
    "InitiationDate"             => date('Y-m-d'),
    "TransactionLocked"          => "true",
    "PartnerTransID"             => uniqid(),
    "TermsLocked"                => "true",
    "AllowReject"                => "true",
    "BrkCommissionBuyerPortion"  => "0",
    "BrkCommissionSellerPortion" => "500",
    "BrokerCommissionPayee"      => "seller"
));

var_dump($transaction);




