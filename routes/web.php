<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return redirect('auth/login');});



//  Authentication
Route::group(['prefix'=>'auth'],function(){
    Route::get('/login','AuthController@index');
    Route::post('/login','AuthController@login');
    Route::get('/logout','AuthController@logout');
});



// Global
Route::group(['prefix'=>'global','middleware'=>['auth']],function(){
    Route::get('/classGrades/{fk_institute}/{fk_class}/{shift}','GlobalController@classGrades');
    Route::get('/classSuggestion/{word}','GlobalController@classSuggestion');
    Route::post('/saveClassSuggestion','GlobalController@saveClassSuggestion');
    Route::get('/profileSuggestion/{word}','GlobalController@profileSuggestion');
    Route::post('/saveProfileSuggestion','GlobalController@saveProfileSuggestion');
    Route::get('/countiesByState/{id}','GlobalController@countiesByState');
    Route::get('/institutesByCounty/{id}','GlobalController@institutesByCounty');
    Route::get('/instituteData/{id}','GlobalController@instituteData');
    Route::get('/userByEmail/{role}','GlobalController@userByEmail');
    Route::get('/zipcodeFilter/{zipcode}','GlobalController@zipcodeFilter');
});



// Dashboard
Route::group(['prefix'=>'dashboard','middleware'=>['auth']],function(){
    Route::get('/','DashboardController@index');
});



// Roles
Route::group(['prefix'=>'roles','middleware'=>['auth']],function(){
    Route::get('/','RolesController@index');
    Route::get('/new','RolesController@newRole');
    Route::post('/new','RolesController@saveRole');
    Route::get('/{id}','RolesController@editRole');
    Route::patch('/{id}','RolesController@updateRole');
    Route::delete('/{id}','RolesController@deleteRole');
});



// Users
Route::group(['prefix'=>'users','middleware'=>['auth']],function(){
    // My profile
    Route::get('/myProfile','UsersController@myProfile');
    Route::patch('/myProfile','UsersController@saveMyProfile');

    // Students
    Route::get('/students','UsersController@getStudents');
    Route::get('/students/new','UsersController@newStudentData');
    Route::post('/students/new','UsersController@saveStudentData');
    Route::get('/students/{id}','UsersController@editStudentData');
    Route::patch('/students/{id}','UsersController@updateStudentData');
    Route::delete('/students/{id}','UsersController@softDeleteStudent');

    // Teachers
    Route::get('/teachers','UsersController@getTeachers');
    Route::get('/teachers/new','UsersController@newTeacherData');
    Route::post('/teachers/new','UsersController@saveTeacherData');
    Route::get('/teachers/{id}','UsersController@editTeacherData');
    Route::patch('/teachers/{id}','UsersController@updateTeacherData');
    Route::delete('/teachers/{id}','UsersController@softTeacherStudent');

    // Basic data
    Route::get('/','UsersController@index');
    Route::get('/new','UsersController@newUser');
    Route::post('/new','UsersController@saveUser');
    Route::get('/{id}','UsersController@editUser');
    Route::patch('/{id}','UsersController@updateUser');
    Route::delete('/{id}','UsersController@deleteUser');
    Route::delete('/softdelete/{id}','UsersController@softDeleteUser');
});



// Education levels
Route::group(['prefix'=>'education_level','middleware'=>['auth']],function(){
    Route::get('/','EducationLevelsController@index');
    Route::get('/new','EducationLevelsController@newEducationLevel');
    Route::post('/new','EducationLevelsController@saveEducationLevel');
    Route::get('/{id}','EducationLevelsController@editEducationLevel');
    Route::patch('/{id}','EducationLevelsController@updateEducationLevel');
    Route::delete('/{id}','EducationLevelsController@deleteEducationLevel');
});



// Institutes
Route::group(['prefix'=>'institutes','middleware'=>['auth']],function(){
    Route::get('/','InstitutesController@index');
    Route::get('/myInstitute','InstitutesController@myInstitute');
    Route::patch('/myInstitute','InstitutesController@saveMyInstitute');
    Route::get('/new','InstitutesController@newInstitute');
    Route::post('/new','InstitutesController@saveInstitute');
    Route::get('/{id}','InstitutesController@editInstitute');
    Route::patch('/{id}','InstitutesController@updateInstitute');
    Route::delete('/{id}','InstitutesController@deleteInstitute');

});



// Grades-Groups
Route::group(['prefix'=>'grades-groups','middleware'=>['auth']],function(){
    Route::get('/','GradesGroupsController@index');
    Route::patch('/{id}','GradesGroupsController@saveInstituteData');
    Route::get('/instituteData/{id}','GradesGroupsController@instituteData');
});



// Classes
Route::group(['prefix'=>'classes','middleware'=>['auth']],function(){
    Route::get('/','ClassesController@index');
    Route::get('/new','ClassesController@newClass');
    Route::post('/new','ClassesController@saveClass');
    Route::get('/{id}','ClassesController@editClass');
    Route::patch('/{id}','ClassesController@updateClass');
    Route::delete('/{id}','ClassesController@deleteClass');
});



// Institute classes
Route::group(['prefix'=>'institute_classes','middleware'=>['auth']],function(){
    Route::group(['prefix'=>'assignment'],function(){
        Route::get('/','InstituteClassesController@assignmentTeacher');
        Route::post('/{id}/{fk_teacher}','InstituteClassesController@saveAssignmentTeacher');
    });
    Route::group(['prefix'=>'students'],function(){
        Route::get('/','InstituteClassesController@studentsClasses');
    });
    Route::group(['prefix'=>'teacher'],function(){
        Route::get('/{id}','InstituteClassesController@teacherClasses');
    });

    Route::get('/','InstituteClassesController@index');
    Route::get('/new','InstituteClassesController@newInstituteClass');
    Route::post('/new','InstituteClassesController@saveInstituteClass');
    Route::get('/{id}','InstituteClassesController@editInstituteClass');
    Route::patch('/{id}','InstituteClassesController@upgradeInstituteClass');
    Route::delete('/{id}','InstituteClassesController@deleteInstituteClass');
});



// Profiles
Route::group(['prefix'=>'profiles','middleware'=>['auth']],function(){
    Route::get('/','ProfilesController@index');
    Route::get('/new','ProfilesController@newProfile');
    Route::post('/new','ProfilesController@saveProfile');
    Route::get('/{id}','ProfilesController@editProfile');
    Route::patch('/{id}','ProfilesController@updateProfile');
    Route::delete('/{id}','ProfilesController@deleteProfile');
});



// Activities
Route::group(['prefix'=>'activities','middleware'=>['auth']],function(){
    Route::get('/','ActivitiesController@index');
    Route::get('/new','ActivitiesController@newActivity');
    Route::post('/new','ActivitiesController@saveActivity');
    Route::get('/scores/{id}','ActivitiesController@scoresActivity');
    Route::post('/scores/{id}','ActivitiesController@saveScoresActivity');
    Route::get('/send/{id}','ActivitiesController@sendActivity');
    Route::post('/send/{id}','ActivitiesController@saveSendActivity');
});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
