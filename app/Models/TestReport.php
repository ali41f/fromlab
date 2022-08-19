<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_performed_id',
        'test_report_item_id',
        'value',
    ];

    protected $appends = ["order", "table_num", 'numeric_value', 'is_critical'];

    public function report_item()
    {
        return $this->belongsTo(TestReportItem::class, "test_report_item_id");
    }

    public function GetOrderAttribute()
    {
        return $this->report_item->item_index;
    }

    public function GetNumericValueAttribute()
    {
        if (trim($this->value, '1234567890.') == "")
            if (trim($this->value, '.') == "")
                return null;
            else
                return (float)$this->value;
        else
            return null;
    }

    public function GetIsCriticalAttribute()
    {
        if ($this->numeric_value <= $this->report_item->firstCriticalValue || $this->numeric_value >= $this->report_item->finalCriticalValue)
            return "1";
        else
            return "0";
    }

    public function GetTableNumAttribute()
    {
        return $this->report_item->table_num;
    }

}
