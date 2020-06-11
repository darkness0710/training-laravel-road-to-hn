<?php

namespace App\Repositories\Eloquents;

use App\Lottery;
use App\Repositories\Interfaces\LotteryRepositoryInterface;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use simplehtmldom\HtmlWeb;

class LotteryRepository implements LotteryRepositoryInterface
{

    private $model;

    public function __construct(Lottery $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->orderBy('date', 'DESC')->simplePaginate(7);
    }

    public function find($attribute)
    {
        return $this->model->findOrFail($attribute);
    }

    public function create($attribute)
    {
        $lott = $this->model->create(
            ['date' =>  formatDateDB($attribute['date'])],
            ['result' => $attribute['result']]
        );
        return $lott;
    }
    
    public function massCreate($attributes)
    {   
        $now = Carbon::now();
        $lott = $this->model->create(
            ['date' =>  formatDateDB($attributes['date'])],          
            [['result' => $attributes['result']],['created_at' => $now],['updated_at'=> $now]]
        );
        return $lott;
    }

    public function update($id, array $attribute)
    {
        $lott= $this->model->update(
            ['date' =>  formatDateDB($attribute['date'])],
            ['result' => $attribute['result']]
        );
        return $lott;
    }

    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return true;
    }

    public function search($input)
    {
        $date = formatDateDB($input['date']);
        $result = $input['result'];
        $lottos = $this->model->where('date', 'LIKE', '%' . $date . '%')->orwhere('result', 'LIKE', '%' . $result)->orderBy('date', 'desc')->simplePaginate(7);


        // if (empty($date)) {
        //     $lottos = $this->model->where('result', 'LIKE', '%' . $result)->orderBy('date', 'desc')->simplePaginate(7);
        // } else if (empty($result)) {
        //     $lottos = $this->model->where('date', 'LIKE', '%' . $date . '%')->orderBy('date', 'desc')->simplePaginate(7);
        // } else
        //     $lottos = $this->model->where('date', 'LIKE', '%' . $date . '%')->where('result', 'LIKE', '%' . $result)->orderBy('date', 'desc')->simplePaginate(7);
        return $lottos;
    }
    // public function crawl($attribute)
    // {
    //     $from = $attribute['from'];
    //     $to = $attribute['to'];
    //     if ($from < $to) {
    //         $period = CarbonPeriod::create($from, $to);
    //     } else {
    //         $period = CarbonPeriod::create($to, $from);
    //     }
    //     foreach ($period as $date) {
    //         $url = 'https://xoso.com.vn/xsmb-' . $date->format('d-m-Y') . '.html';
    //         $html = (new HtmlWeb())->load($url);
    //         $this->model->updateOrCreate(
    //             ['date' =>  formatDateDB($date)],
    //             ['result' => $html->find('span#mb_prizeDB_item0', 0)->plaintext],
    //         );
    //         $html->clear();
    //         unset($html);
    //     }
    // }

    // public function fileUpload($file)
    // {
    //     //file details
    //     $filename = $file->getClientOriginalName();
    //     $createdTime = Carbon::now('Asia/Ho_Chi_Minh');
    //     $location = 'uploads';
    //     $file->move($location, $filename);              // move file to its path to read
    //     $filepath = public_path($location . "/" . $filename);
    //     $file = fopen($filepath, "r");                 // Reading file
    //     $importData_arr = array();
    //     $i = 0; //starting row to read 
    //     while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
    //         $num = count($filedata); //count row number
    //         if ($i == 0) {
    //             $i++; //skip row 0 because it's column name
    //             continue;
    //         }
    //         for ($c = 0; $c < $num; $c++) {
    //             $importData_arr[$i][] = $filedata[$c]; //import row into array of import data
    //         }
    //         $i++;
    //     }
    //     fclose($file);
    //     foreach ($importData_arr as $importData) {
    //         $this->model->updateOrCreate(
    //             ['date' => formatDateDB($importData[0])],
    //             [
    //                 'result' => $importData[1],
    //                 'created_at' => $createdTime,
    //                 'updated_at' => $createdTime
    //             ]
    //         );
    //     }
    // }
}
