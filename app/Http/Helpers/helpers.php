<?php
use Carbon\Carbon;
use App\Exceptions\CustomException;
use App\Exceptions\NotificationException;
use App\Services\Json;//
use Illuminate\Support\Facades\Storage;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Http\UploadedFile;

//получить business_type по business_type_id
function getBusinessType(int  $business_type_id):string
{
    $collect = collect(config('myconfig.business_type_info'));
    $first = $collect->firstWhere('id', $business_type_id);
    if(empty($first) || is_null($first["id"])) CustomException(1006);
    return $first["name"];
}

//получить ИД типа бизнеса по типу бизнса
function getBusinessTypeId(string  $business_type):int
{
    $collect = collect(config('myconfig.business_type_info'));
    $first = $collect->firstWhere('name', $business_type);
    if(empty($first) || is_null($first["id"])) CustomException(1006);
    return $first["id"];
}

//кидаем Л
//и (МЛ и значение МЛ (например 11мл)), и получим Л 0.011л
//если мы кинули Л и хотим полуцчить Л то получим значение тоже что и кинули(типа зря)
/*
    $numbersAfterDot ковло чисел после точки
    $idOne у него надо вычесть, например это Л
    $idTwo это надо вычесть например МЛ
    $idTwoValue а это значени его равно например 11мл
*/
function getQuantityByUnitMeasurementAndValue(int $idOne, int $idTwo, float|int $idTwoValue, int $numbersAfterDot = 2):float|int
{
    $first = getUnitMeasurement($idTwo);
    if(empty(checkMeasuresUnitMeasurement($idOne, $idTwo)))  CustomException(2012);
    if(empty($first) || empty($first['measures'])) CustomException(2013);
    
    foreach ($first['measures'] as $key => $value) {
        if($value['id'] == $idOne){
            return bcmul($idTwoValue, $value['measures_value'], $numbersAfterDot);
        }
    }
    return $idTwoValue;    
}

//смотрим правильность указаная колва, если еденица ШТ а колво  1,5 то нельзя, оно должно быть целым числом
function checkValueUnitMeasurement(int $id, float|int $value):bool
{
    $first = getUnitMeasurement($id);
    if($first['value'] == 'int' && !is_int($value)) return false;//если int то строго int
    //если float то можено и float и int
    //if($first['value'] == 'float' && is_float($value)) return true;     
    return true;
}

//сопостовими ли КГ и МЛ например //d(checkMeasuresUnitMeasurement(4, 2)) 4 это г он сопоставим с 2 - это кг
function checkMeasuresUnitMeasurement(int $id_one, int $id_two):bool
{
    $first = getUnitMeasurement($id_one);    
    if(empty($first) || empty($first['measures'])) return false;
    
    foreach ($first['measures'] as $key => $value) {
        if($value['id'] == $id_two) return true;
    }
    return false;
}

//получить еденицу измерения по ид
function getUnitMeasurement(int $id):array
{
    $collect = collect(config('myconfig.unit_measurements'));
    $first = $collect->firstWhere('id', $id);
    if(empty($first)) CustomException(1006);
    return $first;
}

//отправялем номер вида +7 или 7(999) получим 8999
function ConvertPhone(string $phone)
{
    //return PhoneNumber::make($phone, 'RU')->formatForMobileDialingInCountry('RU');
    $phoneS =  new PhoneNumber($phone, 'RU');
    return $phoneS->formatForMobileDialingInCountry('RU');
}


/*function guard_admin():string
{
    return 'admin';
}*/

/*
    Загрузка файлов в директоию / возможность грузить как 1 ффайл так и массив файлов
    request
    name_request что ищем в request
    download_directory куда запишем
    disk 
    response array путей к файлам
    // $path = H_UploadFile(request(), 'file', 'product_write_offs');
*/
function H_UploadFile($request, string $name_request = 'file', string $download_directory = 'file', string $disk = 'public'):array
{
    $path = [];
        if($request->hasFile($name_request)){
            $file = $request->file($name_request);         
            if(is_array($file) && count($file) > 0){
                foreach ($file as $value) {
                    $path[] = $value->store($download_directory, $disk);
                }
            }
            else {
                $path[] = $file->store($download_directory, $disk);
            }
                    
        }
    return $path;
}

//Загрузка файла
function F_UploadFile(UploadedFile $file, string $download_directory = 'file', string $disk = 'public'):string|null
{
    return $file->store($download_directory, $disk);
}



//получить информаию системных настроек которые запонлил админ
function GetSystemSettingAdmin():\App\Models\AdminSystemSetting
{
    $response = \App\Models\AdminSystemSetting::find(1);   
    if(empty($response)) CustomException(2000);     
    return $response;
}



//чек сущ владельца
function CheckOwnerId(int $owner_id):bool
{
   return \App\Models\Owner::where('id', $owner_id)->exists();
}

//Удаление файла
function DeleteFile(string $file, string $disk = 'public')
{
   Storage::disk($disk)->delete($file);
}


function d(mixed $dd = [])
{
    print_r($dd);exit;
}

function auth_user_id(string $guard = '')
{
    return Auth::guard($guard)->user()->id;
}

function JsonSend(string|int|array|object|null $mess = 'success', int $code = 200)
{
    return Json::send($mess, $code);
}

function CustomException(string|int $rutext = 0, int $code = 404)
{
    CustomException::error($rutext, $code);
}

function NotificationException(string|int $rutext = 0, int $code = 404)
{
    NotificationException::error($rutext, $code);
}

//цена нужно отнять проценты Пример вычитания 20% из 1000: = 800
function HelperSubtractPercent(int $price, int $percent):int
{
    return $price - ($price * ($percent / 100));
}

//больше ли дата старт, даты конца // если дата стустра больше даты конца то true
function HelperComparisonDate(string $date_start, string $date_end):bool
{
        $date_start = Carbon::parse($date_start);
        $date_end = Carbon::parse($date_end);
        return  $date_start > $date_end ? true : false;
        
}

//кол во дней между датами
function HelperDiffIndays(string $date_start, string $date_end):int
{
        $date_start = Carbon::parse($date_start);
        $date_end = Carbon::parse($date_end);
        return $date_start->diffIndays($date_end);
}


/*
 * отправка email
 * $email - кому
*/
function SendEmail(string $email, string $subject, string $title, string $body):bool
{
        $details = [
            'subject' => $subject,//тело письма
            'title' => $title,//заголовок внутри письма
            'body' => $body // сам текст письма
        ];

        \Mail::to($email)->send(new \App\Mail\SendEmail($details));
        return true;
}

//удаляем выходные дни
//массив с датами общий список и массив с датами выходных
function HelperDeletingWeekends(array $list_dates, array $days_offs):array
{
       if($days_offs && is_array($days_offs) && count($days_offs) > 0){
            foreach ($days_offs as $value) {
                if (in_array($value, $list_dates)) {
                    $key = array_search($value, $list_dates);
                    unset($list_dates[$key]);
                }
            }            
        }
        return $list_dates;
}

/*
массив с датами и массив с днями неделями [[1(ВС), 0(ПН), 1, 1, 0, 1, 1(СБ)]] 
**/
function HelperDeleteDaysOffWeek(array $list_dates, array $working_days):array
{
    //[0] => 1(ВС рабочий)            [1] => 1            [2] => 1            [3] => 1            [4] => 0            [5] => 1            [6] => 1
        if($list_dates && is_array($list_dates) && count($list_dates) > 0){
            foreach ($list_dates as $key => $value) {
                $dt = Carbon::parse($value);
                //echo $dt->dayOfWeek;//день недели по числу 1(пн) 2 3 4 5 6 0(вс)
                //1 выбрал рабочим - 0 выходной
                //если это число выходное, то удалим из спсика дат
                if($working_days[$dt->dayOfWeek] == 0) unset($list_dates[$key]);
            }
        }
        return $list_dates;
}

//получить время от даты с временем H:i
function HelperGetTimeFromDate(string $date, string $format = 'Y-m-d H:i:s'):string|bool
{
    return Carbon::createFromFormat($format, $date)->format('H:i');
}

//добавить минукты к дате
function HelperAddMinute(string $date, int $minute):string|bool
{
    $dt = Carbon::parse($date);
    return $dt->addMinutes($minute);
}

//отнять минукты к дате
function HelperSubMinute(string $date, int $minute):string|bool
{
    $dt = Carbon::parse($date);
    return $dt->subMinute($minute);
}

//добавить дни к дате
function HelperAddDay(string $date, int $count_day):string|bool
{
    $dt = Carbon::parse($date);
    return $dt->addDays($count_day);
}

//добавить месяцы к дате
function HelperAddMonth(string $date, int $count_month):string|bool
{
    $dt = Carbon::parse($date);
    return $dt->addMonth($count_month);
}

//чекаем формат даты иил времени //является ли например дата 2020-01-01 формату Y-m-d H:i
function HelperCheckDate(string $date, string $format = 'Y-m-d')
{
    return \DateTime::createFromFormat($format, $date);
}

//преобразовать дату к нужному виду но сначала нужно бы ее проверить запросом выше
function HelperConvertDate(string $date, string $format = 'Y-m-d')
{
    return Carbon::parse($date)->translatedFormat($format);
}

//добавить UTC
function HelperAddUtc(string $date, string $utc, string $format = 'Y-m-d H:i:s')
{    
    $date = new \DateTime($date);
    $date->modify($utc.' hours');//+3
    return $date->format($format);
}

//входит ли дата в диапозон date_check - дата которую смотрим
//HelperCheckDateDiapozon('14:00', '15:00', '15:00', 'H:i') 1500 входит в 1500 короче равна тоже входит
function HelperCheckDateDiapozon(string $date_start, string $date_end, string $date_check, string $format = 'Y-m-d H:i:s'): bool
{
    $date_start  = Carbon::createFromFormat($format, $date_start)->format($format);
    $date_end  = Carbon::createFromFormat($format,$date_end)->format($format);
    $date_check  = Carbon::parse($date_check);
    return $date_check->between($date_start, $date_end); // true false
}
