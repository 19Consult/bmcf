<?php

namespace App\Http\Controllers;

use App\Mail\AccountDeletionNotification;
use App\Mail\MailTestTemplateBlade;
use App\Models\FavoriteProject;
use App\Models\Projects;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\CategoryName;
use App\Models\accountDeletionConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use League\Csv\Writer;
use App\Models\SettingsTable;
use App\Models\ReportProblems;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoriesExport;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return redirect(route("admin.adminSettingsPage"));
        //return view("admin.dashboard");
    }

    public function users(Request $request){

        $perPage = $request->input('perPage', 10);
        $sortField = $request->input('sortField', 'id');
        $sortOrder = $request->input('sortOrder', 'desc');

        $searchTerm = $request->input('searchTerm', '');
        $searchTermResult = $searchTerm;

        $country_code = (new CountryController)->getCodeCountry($searchTerm);

        if ($country_code){
            $searchTerm = $country_code;
        }

        $data['title_page'] = 'Users';

        $users = User::where(function ($query) use ($searchTerm) {
            $query->where('email', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereHas('detail', function ($query) use ($searchTerm) {
                    $query->where('user_id', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('first_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('date_of_birth', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('company_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('occupation', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('street', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('postal_code', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('salutation', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('country', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('city', 'LIKE', '%' . $searchTerm . '%');
                });
            })
            ->with('detail')
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                switch ($sortField) {
                    case 'last_name':
                        return $query->orderBy(UserDetail::select('last_name')->whereColumn('users_details.user_id', 'users.id'), $sortOrder);
                    case 'company_name':
                        return $query->orderBy(UserDetail::select('company_name')->whereColumn('users_details.user_id', 'users.id'), $sortOrder);
                    case 'country':
                        return $query->orderBy(UserDetail::select('country')->whereColumn('users_details.user_id', 'users.id'), $sortOrder);
                    default:
                        return $query->orderBy($sortField, $sortOrder);
                }
            })
            ->paginate($perPage);

        $data['users'] = $users;


        return view("admin.users", [
            'data' => $data,
            'perPage' => $perPage,
            'sortOrder' => $sortOrder,
            'searchTerm' => $searchTermResult,
            'sortField' => $sortField,
        ]);
    }

    public function block($id){
        $user = User::find($id);
        $user->is_blocked = true;
        $user->save();

        return redirect()->back()->with('success', 'User has been blocked.');
    }

    public function unblock($id){
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

    public function usersDelete(){
        $data['title_page'] = 'Delete users';

        $users = [];
        $delete_users = accountDeletionConfirmation::all();
        if (!empty($delete_users)){
            foreach ($delete_users as $val){
                $users[] = User::where('id', $val->user_id)
                    ->with('detail')
                    ->get();
            }
            $data['users'] = $users;
        }

        return view("admin.users-delete", [
            'data' => $data,
        ]);
    }

    public function deleteUser(Request $request, $id){
        $email = $request->get('email');

        //delete user
        User::find($id)->delete();
        accountDeletionConfirmation::where('user_id', $id)->delete();
        UserDetail::where('user_id', $id)->delete();

        Projects::where('user_id', $id)->delete();
        FavoriteProject::where('user_id', $id)->delete();

        //Check user again
        $user_check_again = User::find($id);
        if ($user_check_again) {
            $user_check_again->delete();
        }

        //send email user
        try {
            //Mail::to($email)->send(new AccountDeletionNotification());
            $text = 'Your account has been successfully deleted.';
            $data = [
                'subject' => '',
                'first_name' => '',
                'text_body' => '<p>' . $text . '</p>',
                'text_before' => '',
            ];

            Mail::to($email)->send(new MailTestTemplateBlade($data));

        } catch (\Exception $e) {
            $e->getMessage();
        }

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function categoryList(Request $request){
        $data['title_page'] = 'Category list';

        $data['category_list'] = [];

        $searchTerm = $request->get('q', false);

        if($searchTerm){
            $category_list = CategoryName::where('category_name', 'LIKE', '%' . $searchTerm . '%')->orderBy('category_name', 'asc')->get();
        }else{
            //$category_list = CategoryName::all();
            $category_list = CategoryName::orderBy('category_name', 'asc')->get();
        }

        if (isset($category_list) && !empty($category_list)){
            $data['category_list'] = $category_list;
        }

        return view("admin.category-list", [
            'data' => $data,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function categoryCreate(Request $request){
        $data['title_page'] = 'Create category';

        if($request->get("category_name")){
            $category_name = CategoryName::create(['category_name' => $request->get("category_name")]);
            return redirect(route("admin.category.list"))->with('success', 'Category added successfully!');
        }

        return view("admin.category-edit", [
            'data' => $data,
        ]);
    }

    public function categoryEdit($id, Request $request){
        $data['title_page'] = 'Edit category';

        $data['category'] = CategoryName::where('id', $id)->first();

        $data['type'] = 'edit';

        return view("admin.category-edit", [
            'data' => $data,
        ]);
    }

    public function categorySave($id, Request $request){

        $category = CategoryName::where('id', $id)->first();
        $category->update(['category_name' => $request->get("category_name")]);

        return redirect(route("admin.category.list"))->with('success', 'Category updated successfully!');
    }

    public function categoryDelete($id){
        CategoryName::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

    public function settingsPage(){
        $data['title_page'] = 'Settings';

        $data['setting'] = [];
        $setting = SettingsTable::all();
        foreach ($setting as $key => $value){
            $data['setting'][$value->name] = $value->value;
        }

        return view("admin.settings-page", [
            'data' => $data,
        ]);
    }

    public function settingsPageSave(Request $request){

        $r = SettingsTable::where('name', 'count_posts')->first();
        $r->update([
           'value' => $request->get("count_posts"),
        ]);

        return redirect()->back()->with('success', 'Settings have been saved.');
    }

    public function showReports(Request $request){
        $data['title_page'] = 'Problem Report';

        $perPage = $request->input('perPage', 10);
        $sortField = $request->input('sortField', 'id');
        $sortOrder = $request->input('sortOrder', 'desc');

        $reportProblems = ReportProblems::orderBy($sortField, $sortOrder)->paginate($perPage);

        $data['reportProblems'] = $reportProblems;

        return view("admin.reports", [
            'data' => $data,
            'perPage' => $perPage,
            'sortOrder' => $sortOrder,
            'sortField' => $sortField,
        ]);


    }

    public function adminSettingsPage(){
        $data['title_page'] = 'My Profile';
        $data['user'] = Auth::user();
        $data['userDetail'] = null;

        $user_detail = UserDetail::where('user_id', Auth::id())->first();
        if ($user_detail){
            $data['userDetail'] = $user_detail;
        }

//        $data['category'] = CategoryName::all();
//
//        $data['allCountry'] = (new CountryController)->allCountries();
//        unset($data['allCountry']['EU']);

//        if(User::checkOwner()){
//            return view("owner.profile-dashboard-founder", ['data' => $data]);
//        }
//        if (User::checkInvestor()){
//            return view("investor.profile-dashboard-co-founder", ['data' => $data]);
//        }
        return view("admin.admin-settings", ['data' => $data]);
        // admin-settings.blade.php
    }

    public function adminSettingsPageSave(Request $request){

        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(auth()->id()),
            ],
        ]);


        $user = Auth::user();
        $user_id = $user->id;
        $user_detail = UserDetail::where('user_id', $user_id)->first();

        $data = [
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'date_of_birth' => date("Y-m-d"),
            'phone' => '000000000',
//            'about_you' => $request->get('about_you'),
//            'company_name' => $request->get('company_name'),
//            'occupation' => $request->get('occupation'),
//            'street' => $request->get('street'),
//            'house' => $request->get('house'),
//            'postal_code' => $request->get('postal_code'),
//            'salutation' => $request->get('salutation'),
//            'country' => $request->get('country'),
//            'city' => $request->get('city'),
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $path = public_path('profile-photos/');
            $photo->move($path, $filename);
            $data['photo'] = 'profile-photos/' . $filename;


//            $user_module = User::where('id', $user_id)->first();
//            // сохраняем в storage-директории
//            $path_storage = storage_path('app/public/users-avatar/');
//            $photo->move($path_storage, $filename);
//            $user_module->avatar = $filename;
//            $user_module->save();


        }


//        $data['new_project_email'] = empty($request->input('new_project_email')) ? false : true;
//        $data['notification_email'] = empty($request->input('notification_email')) ? false : true;
//        $data['nda_approved_email'] = empty($request->input('nda_approved_email')) ? false : true;

//        $data['basic_interests_investor'] = $request->get('basic_interests_investor');
//        $data['categorty1_investor'] = $request->get('categorty1_investor');
//        $data['categorty2_investor'] = $request->get('categorty2_investor');
//        $data['categorty3_investor'] = $request->get('categorty3_investor');


        $user->email = $request->get('email');
        $user->name = $request->get('first_name') . ' ' . $request->get('last_name');
        $user->save();

        if ($user_detail) {
            $user_detail->update($data);
        } else {
            $data['user_id'] = $user_id;
            UserDetail::create($data);
//            if(User::checkOwner()){
//                return redirect(route("createProject"));
//            }
        }

        return redirect()->back()->with('success', 'Changes saved successfully!');
    }


    public function downloadExselCategories()
    {
        return Excel::download(new CategoriesExport(), 'categories.xlsx');
    }

    public function uploadExselCategories(Request $request)
    {
        // Drop old categories
        CategoryName::truncate();

        if ($request->hasFile('categories_file')) {
            $file = $request->file('categories_file');

            // Check type file
            if ($file->getClientOriginalExtension() == 'xlsx' || $file->getClientOriginalExtension() == 'xls') {
                //PhpSpreadsheet
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                // For .xls format use: $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                if($file->getClientOriginalExtension() == 'xls'){
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }

                $spreadsheet = $reader->load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();

                // Reading categories from file and saving to database
                foreach ($worksheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $categoryName = null;
                    foreach ($cellIterator as $cell) {
                        $categoryName = $cell->getValue();
                        break; // Take only the first cell in a row
                    }

                    if ($categoryName) {
                        CategoryName::create([
                            'category_name' => $categoryName,
                        ]);
                    }
                }

                return redirect()->back()->with('success', 'The list of categories has been successfully updated');
            } else {
                return redirect()->back()->with('error', 'Invalid file format. Please upload the excel file');
            }
        }

        return redirect()->back()->with('error', 'File upload error');
    }


    public function editUserProfile($id){
        $data['user'] = User::find($id);
        $data['userDetail'] = null;
        $data['title_page'] = 'Profile: ' . $data['user']->name;

        $user_detail = UserDetail::where('user_id', $id)->first();
        if ($user_detail){
            $data['userDetail'] = $user_detail;
        }

        $data['category'] = CategoryName::orderBy('category_name', 'asc')->get();

        $data['allCountry'] = (new CountryController)->allCountries();
        unset($data['allCountry']['EU']);
        asort($data['allCountry']);

        if(User::checkOwner($id)){
            return view("admin.profile-dashboard-founder", ['data' => $data]);
        }
        if (User::checkInvestor($id)){
            return view("admin.profile-dashboard-co-founder", ['data' => $data]);
        }
    }

    public function saveUserProfile($id, Request $request){

        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'photo' => 'image|max:2048',
        ]);

        $user = User::find($id);
        $user_id = $user->id;
        $user_detail = UserDetail::where('user_id', $user_id)->first();

        $data = [
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'date_of_birth' => $request->get('date_of_birth'),
            'phone' => $request->get('code_phone') . ' ' . $request->get('phone'),
            'about_you' => $request->get('about_you'),
            'company_name' => $request->get('company_name'),
            'occupation' => $request->get('occupation'),
            'street' => $request->get('street'),
            'house' => $request->get('house'),
            'postal_code' => $request->get('postal_code'),
            'salutation' => $request->get('salutation'),
            'country' => $request->get('country'),
            'city' => $request->get('city'),
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $path = public_path('profile-photos/');
            $photo->move($path, $filename);
            $data['photo'] = 'profile-photos/' . $filename;
        }

        $data['basic_interests_investor'] = $request->get('basic_interests_investor');
        $data['categorty1_investor'] = $request->get('categorty1_investor');
        $data['categorty2_investor'] = $request->get('categorty2_investor');
        $data['categorty3_investor'] = $request->get('categorty3_investor');

        $data['city_other'] = empty($request->input('city_other')) ? false : true;
        if( !empty($request->input('city_other'))  ){
            $data['city'] = $request->get('city_other_name');
        }

        $user->email = $request->get('email');
        $user->name = $request->get('first_name') . ' ' . $request->get('last_name');
        $user->save();

        if ($user_detail) {
            $user_detail->update($data);
        } else {
            $data['user_id'] = $user_id;
            UserDetail::create($data);
        }

        if ($request->has('new_password') && $request->has('new_password_confirmation')){
            $request->validate([
                'new_password' => 'required|min:6|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($request->get('new_password')),
            ]);
        }

        return redirect()->back()->with('success', 'Changes saved successfully!');

    }

    public function deletePhotoUserProfile(Request $request){
        $user_id = $request->user_id;
        $user_detail = UserDetail::where('user_id', $user_id)->first();

        if ($user_detail) {
            $data['photo'] = null;
            $user_detail->update($data);
        }

        return response()->json([
            'message' => 'Successfully!',
        ]);
    }

}
