<?php

namespace CN\App\Models;

/**
 * Dealer Model to convert API data to usable data
 * 
 * @param array $data
 *
 * @property string $id
 * @property string $name
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone
 * @property array [float]$location - latitude and longitude
 * @property array [string]$products - list of products
 */
class Dealer
{
    public string $id;
    public ?string $name;
    public ?string $address;
    public ?string $city;
    public ?string $state;
    public ?string $zip;
    public ?string $phone;
    public array $location = [
        'latitude' => 0,
        'longitude' => 0
    ];
    public array $products = [];

    public function __construct($data)
    {
        if (isset($data['attributes'])) {
            $url = $data['attributes']['url'];
            $url_parts = explode('/', $url);
            $id = end($url_parts) ?? '';
        } else {
            $id = '';
        }

        $this->id = $id;
        $this->name = $data['Name'];
        $this->address = $data['ShippingStreet'];
        $this->city = $data['ShippingCity'];
        $this->state = $data['ShippingState'];
        $this->zip = $data['ShippingPostalCode'];
        $this->phone = $data['Phone'];

        $this->location = [
            'latitude' => $data['Latitude__c'],
            'longitude' => $data['Longitude__c']
        ];

        $products = explode(';', $data['Product_List__c']);
        $products = array_map(function ($product) {
            return strtolower(str_replace('®', '', $product));
        }, $products);

        $this->products = $products;
    }
}
