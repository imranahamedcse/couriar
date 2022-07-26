<?php
namespace App\Repositories\Deliverycategory;

interface DeliverycategoryInterface {

    public function all();

    public function get($id);

    public function store($request);

    public function update($request);

    public function delete($id);
}
