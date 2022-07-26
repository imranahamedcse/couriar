<?php

use App\Enums\ParcelStatus;

return [
    ParcelStatus::PICKUP_ASSIGN                 => 'পিকআপ অ্যাসাইনড',
    ParcelStatus::PICKUP_RE_SCHEDULE            => 'পার্সেল পিকআপ রি-শিডিউল',
    ParcelStatus::RECEIVED_BY_PICKUP_MAN        => 'পার্সেল পিকআপ ম্যান পেয়েছে',
    ParcelStatus::RECEIVED_WAREHOUSE            => 'পার্সেল গুদামে গৃহীত হয়েছে',
    ParcelStatus::TRANSFER_TO_HUB               => 'হাবে পার্সেল স্থানান্তর',
    ParcelStatus::RECEIVED_BY_HUB               => 'হাব দ্বারা গৃহীত',
    ParcelStatus::DELIVERY_MAN_ASSIGN           => 'ডেলিভারি ম্যান অ্যাসাইনড',
    ParcelStatus::DELIVERY_RE_SCHEDULE          => 'ডেলিভারি  রি-শিডিউল',

    ParcelStatus::DELIVER                       => 'ডেলিভার',
    ParcelStatus::RETURN_TO_COURIER             => 'কুরিয়ার-এ ফেরত',
    ParcelStatus::RETURN_ASSIGN_TO_MERCHANT     => 'মার্চেন্টের কাছে অ্যাসাইনড ফেরত দিন',
    ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE   => 'মার্চেন্টের কাছে পুনরায় সময়সূচী অ্যাসাইনড ফেরত দিন',

    ParcelStatus::DELIVERED                     => 'ডেলিভারড',
    ParcelStatus::PARTIAL_DELIVERED             => 'আংশিক ডেলিভারড',
    ParcelStatus::RETURN_WAREHOUSE              => 'গুদাম ফেরত',
    ParcelStatus::ASSIGN_MERCHANT               => 'অ্যাসাইন মার্চেন্ট',
    ParcelStatus::RETURNED_MERCHANT             => 'মার্চেন্টের কাছে ফেরত এসেছে',
    ParcelStatus::RETURN_RECEIVED_BY_MERCHANT   => 'মার্চেন্ট দ্বারা প্রাপ্ত রিটার্ন',

    'hub_name'                                   => 'হাবের নাম',
    'hub_phone'                                  => 'হাব ফোন',
    'delivery_man'                               => 'সরবরাহকারী',
    'delivery_man_phone'                         => 'ডেলিভারি ম্যান ফোন'


];
