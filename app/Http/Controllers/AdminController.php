<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use League\Csv\Writer;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view("admin.dashboard");
    }

    public function users(Request $request){

        $perPage = $request->input('perPage', 20);
        $sortField = $request->input('sortField', 'created_at');
        $sortOrder = $request->input('sortOrder', 'desc');

        $data['title_page'] = 'Users';

        $users = User::with('detail')
            ->orderBy($sortField, $sortOrder)
            ->paginate($perPage);

        $data['users'] = $users;


        return view("admin.users", [
            'data' => $data,
            'perPage' => $perPage,
            'sortOrder' => $sortOrder,
        ]);
    }

    public function block($id)
    {
        $user = User::find($id);
        $user->is_blocked = true;
        $user->save();

        return redirect()->back()->with('success', 'User has been blocked.');
    }

    public function unblock($id)
    {
        $user = User::find($id);
        $user->is_blocked = false;
        $user->save();

        return redirect()->back()->with('success', 'User has been unblocked.');
    }

    public function exportUsers(){
        // Получить данные пользователей из базы данных
        $users = User::all();

        // Создать экземпляр класса Writer
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        // Добавить заголовки CSV-файла
        $name_fields = [
            'id',
            'email',
            'created_at',
            'role',
            'last_activity_at',
            'is_blocked',
            'first_name',
            'last_name',
            'date_of_birth',
            'phone',
            'about_you',
            'company_name',
            'occupation',
            'street',
            'house',
            'postal_code',
            'salutation',
            'country',
            'city',
        ];
        $csv->insertOne($name_fields);

        // Записать данные пользователей в файл
        foreach ($users as $user) {
            $userRole = \App\Models\Role::where('id', $user->role)->first();
            $data = [
                $user->id,
                $user->email,
                $user->created_at,
                $userRole->name,
                $user->last_activity_at,
                $user->is_blocked
            ];

            if(!empty($user->detail->first_name)){
                $data[] = $user->detail->first_name;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->last_name)){
                $data[] = $user->detail->last_name;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->date_of_birth)){
                $data[] = $user->detail->date_of_birth;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->phone)){
                $data[] = $user->detail->phone;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->about_you)){
                $data[] = $user->detail->about_you;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->company_name)){
                $data[] = $user->detail->company_name;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->occupation)){
                $data[] = $user->detail->occupation;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->street)){
                $data[] = $user->detail->street;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->house)){
                $data[] = $user->detail->house;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->postal_code)){
                $data[] = $user->detail->postal_code;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->salutation)){
                $data[] = $user->detail->salutation;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->country)){
                $data[] = $user->detail->country;
            }else{
                $data[] = '';
            }

            if(!empty($user->detail->city)){
                $data[] = $user->detail->city;
            }else{
                $data[] = '';
            }

            $csv->insertOne($data);
        }

        // Отправить файл пользователю для скачивания
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"',
        ];

        return response()->streamDownload(function() use ($csv) {
            echo $csv->getContent();
        }, 'users.csv', $headers);
    }

}
