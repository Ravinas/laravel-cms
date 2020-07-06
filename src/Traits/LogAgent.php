<?php
namespace CMS\Traits;
use CMS\Models\Log;
use CMS\Models\User;

trait LogAgent {

    public function getLogs()
    {
        $crud = ["C" => "Oluşturdu","D" => "Sildi","U" => "Güncelledi"];
        $logs = Log::orderBy('id','desc')->take(5)->get();
        $organized_logs = [];
        foreach($logs as $log)
        {
            $model = explode('\\',$log["loggable_type"]);
            $organized_logs[] = User::find($log["user_id"])->name." ".$model[2]." ".$log["loggable_id"]." ".$crud[$log["crud"]];
        }

        return $organized_logs;
    }

    public function createLog($model,$user,$crud)
    {
        Log::create(["user_id" => $user,"loggable_id" => $model->id,"loggable_type" => get_class($model),"crud" => $crud]);
    }

}
