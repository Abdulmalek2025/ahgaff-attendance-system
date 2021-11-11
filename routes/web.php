<?php

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
Route::get('/master/admin/new',function(){
    return view('admins.addmaster');
});
Route::post('/master/admin/add','AdminController@addmaster')->name('AddMaster');
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/home', function(){

        $user = Auth::User();
        $notes['notes'] = $user->unreadNotifications()->get();
        return view('home')->with($notes);


});
Route::get('/notification/read','AdminController@read');
/*Admins*/
Route::get('/admin/dashboard','AdminController@dashboard')->name('admins.dashboard');
Route::get('/admin/setup','AdminController@setup_dashboard');
Route::get('/admin/admins','AdminController@index')->name('admins.index');
Route::get('/admin/students','AdminController@students')->name('admins.students');
Route::get('/admin/teachers','AdminController@teachers')->name('admins.teachers');
Route::get('/admin/courses','AdminController@courses')->name('admins.courses');
Route::get('/admin/groups','AdminController@groups')->name('admins.groups');
Route::get('/admin/semesters','AdminController@semesters')->name('admins.semseters');
Route::get('/admin/attendances','AdminController@attendances')->name('admins.attendances');
Route::get('/admin/semester_course','AdminController@semester_course')->name('admins.semester_course');
Route::get('/admin/excuses','AdminController@excuses')->name('admins.excuses');
Route::get('/admin/reports','AdminController@reports')->name('admins.reports');
Route::get('admin/setting/reset','AdminController@reset');
Route::get('admin/setting/backup','AdminController@backup');
Route::get('admin/upgrade','AdminController@upgrade');
Route::get('/admin/upgrade/change/major','AdminController@change_major');
Route::post('/admin/upgrade/levelup','AdminController@levelup');
Route::get('/admin/upgrade/copy/data','AdminController@copy_data');
Route::post('/admin/import','AdminController@import');
Route::get('admin/setting/restore','AdminController@restore');
Route::get('/admin/mreports','AdminController@mreport');
Route::get('master/profile','AdminController@profile');
Route::post('admin/update_profile','AdminController@updateProfile');
Route::get('admin/report/tab-4','AdminController@tab_4_report');
/**admin crud */
Route::post('/admins/store','AdminController@store')->name('admin.store');
Route::get('/admins/delete', 'AdminController@delete')->name('admins.delete');
Route::get('/admins/edit','AdminController@edit')->name('admins.edit');
Route::post('/admins/update','AdminController@update')->name('admins.update');
Route::get('/admin/search','AdminController@search')->name('admin.search');
/**dean */
Route::get('/dean/dashboard','DeanController@dashboard')->name('dean.dashboard');
Route::get('/dean/excuses','DeanController@excuse')->name('dean.excuse');
Route::get('/dean/profile','DeanController@profile')->name('dean.profile');
Route::post('/dean/update_profile','DeanController@update_profile')->name('dean.update');
Route::get('/dean/reports','DeanController@report')->name('dean.reports');

/**teachers*/
//Route::get('/teachers/teachers','TeacherController@index')->name('teacher.index');
Route::get('/teacher/dashboard','TeacherController@dashboard')->name('teacher.dashboard');
Route::get('teacher/setup','TeacherController@setup')->name('teacher.setup');
Route::get('/teacher/lecture','TeacherController@lecture')->name('teacher.lecture');
Route::get('/teacher/confirm','TeacherController@confirm')->name('teacher.confirm');
Route::get('/teacher/filter-lecture','TeacherController@filter_lec')->name('teacher.filter_lec');
Route::get('/teacher/filter-attendance','TeacherController@filter_attendance')->name('teacher.filter_attendance');
Route::post('/teacher/update-confirm','TeacherController@update_confirm')->name('teacher.update_confirm');
Route::post('/teacher/open','TeacherController@open')->name('teacher.open');
Route::get('/teacher/profile','TeacherController@profile')->name('teacher.profile');
Route::post('/teacher/updateProfile','TeacherController@updateProfile');
Route::get('/teacher/reports','TeacherController@reports')->name('teacher.reports');
Route::get('/lecture/set-sem-co','TeacherController@setSemCo')->name('teacher.setSemCo');
Route::post('/teacher/delete/lecture','TeacherController@delete_lecture');
Route::get('/teacher/report/lecture/detail/{id}','TeacherController@lecture_detail');

/* teacher crud*/
Route::post('/teachers/store','TeacherController@store')->name('teachers.store');
Route::get('/teachers/delete/{id}', 'TeacherController@delete')->name('teachers.delete');
Route::get('/teachers/edit/{id}','TeacherController@edit')->name('teachers.edit');
Route::post('/teachers/update','TeacherController@update')->name('teachers.update');
Route::get('/teacher/search','TeacherController@search')->name('teachers.search');
/**student */
Route::get('/student/dashboard','StudentController@dashboard')->name('students.dashboard');
Route::get('/student/setup','StudentController@student_setup')->name('student.setup');
Route::get('/student/attendance','StudentController@attendance')->name('students.attendance');
Route::get('/student/attendance/self/{id}/{lecture}','StudentController@attend_self');
Route::get('/student/excuse','StudentController@excuse')->name('students.excuse');
Route::get('/student/profile','StudentController@profile')->name('students.profile');
Route::post('/student/updateProfile','StudentController@updateProfile');
Route::get('/student/reports','StudentController@reports')->name('students.report');
Route::get('/student/chat','StudentController@chat');
Route::post('student/chat/send','StudentController@chat_send');
/**student crud*/
Route::get('/students','StudentController@index')->name('students.index');
Route::post('/students/store','StudentController@store')->name('students.store');
Route::get('/students/delete/{id}', 'StudentController@delete')->name('students.delete');
Route::get('/students/edit/{id}','StudentController@edit')->name('students.edit');
Route::post('/students/update','StudentController@update')->name('students.update');
Route::get('/student/search','StudentController@search')->name('student.search');
/** course crud*/
Route::get('/courses','CourseController@index')->name('courses.index');
Route::post('/courses/store','CourseController@store')->name('courses.store');
Route::get('/courses/delete/{id}', 'CourseController@delete')->name('courses.delete');
Route::get('/courses/edit/{id}','CourseController@edit')->name('courses.edit');
Route::post('/courses/update','CourseController@update')->name('courses.update');
/**semester crud*/
Route::get('/semesters','SemesterController@index')->name('semesters.index');
Route::post('/semesters/store','SemesterController@store')->name('semesters.store');
Route::get('/semesters/delete/{id}', 'SemesterController@delete')->name('semesters.delete');
Route::get('/semesters/edit/{id}','SemesterController@edit')->name('semesters.edit');
Route::post('/semesters/update','SemesterController@update')->name('semesters.update');
/** */
Route::post('/collage/store','SemesterController@collage_store')->name('collage.store');
Route::get('/collage/delete/{id}', 'SemesterController@collage_delete')->name('collage.delete');
Route::get('/collage/edit/{id}','SemesterController@collage_edit')->name('collage.edit');
Route::post('/collage/update','SemesterController@collage_update')->name('collage.update');
Route::get('/new_collage/store','SemesterController@collages');
/** */
Route::post('/major/store','SemesterController@major_store')->name('major.store');
Route::get('/major/delete/{id}', 'SemesterController@major_delete')->name('major.delete');
Route::get('/major/edit/{id}','SemesterController@major_edit')->name('major.edit');
Route::post('/major/update','SemesterController@major_update')->name('sememajorsters.update');
/**group crud */

Route::get('/groups','GroupController@index')->name('groups.index');
Route::post('/groups/store','GroupController@store')->name('groups.store');
Route::get('/groups/delete/{id}', 'GroupController@delete')->name('groups.delete');
Route::get('/groups/edit/{id}','GroupController@edit')->name('groups.edit');
Route::post('/groups/update','GroupController@update')->name('groups.update');
Route::get('/groups/edit-student/{id}','GroupController@editStudent')->name('groups.editStudent');
Route::post('/groups/update-student','GroupController@updateStudent')->name('groups.updateStudent');
Route::get('/groups/filter','GroupController@filter');

/**attendanc */
Route::post('/attendance/update','AttendanceController@update');
Route::post('student/attendance/update','AttendanceController@student_update');
Route::get('/attendance/set-group','AttendanceController@setSemesterCourse');
Route::get('/attendance/filter','AttendanceController@filter');
Route::get('/attendance/filter-lecture','AttendanceController@filterLecture');

/**semester course */
Route::get('/semester-course','SemesterCourseController@index')->name('semseter-course.index');
Route::get('/semester-course/openaddmodal','SemesterCourseController@openAddModal')->name('semseter-course.store');
Route::post('/semester-course/store','SemesterCourseController@store')->name('semseter-course.store');
Route::get('/semester-course/delete/{id}', 'SemesterCourseController@delete')->name('semseter-course.delete');
Route::get('/semester-course/edit/{id}','SemesterCourseController@edit')->name('semseter-course.edit');
Route::post('/semester-course/update','SemesterCourseController@update')->name('semseter-course.update');
/**excuse  */
Route::get('/excuses','ExcuseController@index')->name('excuses.index');
Route::post('/excuses/store','ExcuseController@store')->name('excuses.store');
Route::get('/excuses/delete', 'ExcuseController@delete')->name('excuses.delete');
Route::get('/excuses/edit','ExcuseController@edit')->name('excuses.edit');
Route::post('/excuses/update','ExcuseController@update')->name('excuses.update');
Route::post('student/excuses/store','ExcuseController@student_store')->name('excuse.student.excuse');
Route::post('student/excuses/update','ExcuseController@student_update')->name('excuse.student.update');
Route::get('student/excuses/broadcasttodean','ExcuseController@broadcast_to_dean');
Route::post('dean/excuses/accept','ExcuseController@dean_excuse_accept')->name('excuse.dean.accept');
Route::post('dean/excuses/update','ExcuseController@dean_update');
/**admin reports */
Route::get('/report/admin_setup','AdminController@report_setup')->name('admin.report_setup');
Route::get('admin/report/semester_report','AdminController@semester_report')->name('admin.semester_report');
Route::get('admin/report/course_report','AdminController@course_report_setup')->name('admin.course.report.setup');
Route::get('admin/report/change_course','AdminController@change_course')->name('admin.change.course');
Route::get('admin/report/change_groups','AdminController@change_group')->name('admin.change.group');
Route::get('admin/report/admin-tab-3-auto-complete','AdminController@admin_tab_3_search')->name('admin-tab-3-search');
Route::get('admin/report/one-student-report','AdminController@one_student_report')->name('admin.student.report');
Route::post('admin/report/mail','AdminController@mail');
/**report teacher */
Route::get('/report/semester_course','TeacherController@report_semester_courses')->name('report.semester_courses');
Route::get('/report/semester_course_report','TeacherController@report_for_one_sem_co')->name('report.onesemco');
Route::get('/report/teatcher_setup','TeacherController@set');
Route::get('/report/tab-3-auto-complete','TeacherController@tab_3_search')->name('tab-3-search');
Route::get('/report/one-student-report','TeacherController@one_student_report')->name('report.one_student_report');
Route::get('/report/course_report','TeacherController@course_report')->name('teacher.course.report');
Route::get('/report/semester_course_change','TeacherController@semester_course_change');
/**student reports */
Route::get('/report/student_setup','StudentController@student_report_setup');
Route::get('student/report/change_course','StudentController@change_courses');
