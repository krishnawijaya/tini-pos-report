<?php

namespace KrishnaWijaya\TiniPosReport\Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Illuminate\Support\Facades\DB;

class DataRowCustomColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::customColumns() as $column) {
            $dataType = DataType::where("slug", $column["data_type_slug"])->first();

            if ($dataType) {
                $column["data"]["data_type_id"] = $dataType->id;
                $dataRows = DataRow::where("data_type_id", $dataType->id)->get();
                $afterField = $dataRows->first(fn ($dataRow) => $dataRow->field == $column["after_field"]);

                if ($afterField) {
                    $column["data"]["order"] = $afterField->order + 1;
                    $remainFields = $dataRows->filter(fn ($dataRow) => $dataRow->order >= $column["data"]["order"]);
                    $remainFields->each(fn ($remainField) => DataRow::where("id", $remainField->id)->increment("order"));
                }

                DataRow::firstOrCreate($column["data"]);
            }
        }
    }

    public  static function customColumns()
    {
        return [
            [
                "data_type_slug" => "barang",
                "after_field"    => "harga",
                "data" => [
                    "data_type_id"   => null,
                    "display_name"   => "Harga Beli",
                    "field"          => "harga_beli",
                    "type"           => "number",
                    "required"       => 0,
                    "browse"         => 1,
                    "read"           => 1,
                    "edit"           => 0,
                    "delete"         => 0,
                    "order"          => 1,
                    "details"        => DB::raw('"{}"'),
                ]
            ],
        ];
    }
}
