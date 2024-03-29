<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPerformed extends Model
{
    use HasFactory;
    public $table = 'test_performeds';

    protected $fillable = [
        'available_test_id',
        'patient_id',
        'status',
        'fee',
        'type',
        'specimen',
        'comments',
        'referred',
//        'testResult',
        'informed_by',
        'informed_to'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function availableTest()
    {
        return $this->belongsTo(AvailableTest::class);
    }
    public function GetCategoryAttribute(){
        return $this->availableTest->category_id;
    }
    public function testPerformedEditor(){
        return $this->hasOne(TestperformedEditor::class);
    }
    public function GetEditorAttribute(){
        return $this->testPerformedEditor->editor;
    }
    public function testReport(){
        return $this->hasMany(TestReport::class);
    }
    public static function next_id()
    {
        return static::max('id') + 1;
    }
    public function widal(){
        return $this->hasMany(TestperformedWidal::class);
    }

    public function heading(){
        return $this->hasOne(TestperformedWidal::class)->where("type","test_performed_heading");
    }
    public function heading2(){
        return $this->hasOne(TestperformedWidal::class)->where("type","test_performed_heading2");
    }
    public function heading0(){
        return $this->hasOne(TestperformedWidal::class)->where("type","test_performed_heading0");
    }
}
