<?php

use Illuminate\Database\Seeder;
use App\Permission;
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 创建权限
        $createPermission = new Permission();
        $createPermission->name         = 'permission-store';
        $createPermission->display_name = 'Create Permission';
        $createPermission->description  = 'create new permission';
        $createPermission->save();

        // 查看权限详情
        $showPermission = new Permission();
        $showPermission->name         = 'permission-show';
        $showPermission->display_name = 'Show Permission';
        $showPermission->description  = 'show a permission';
        $showPermission->save();

        // 删除权限
        $destroyPermission = new Permission();
        $destroyPermission->name         = 'permission-destroy';
        $destroyPermission->display_name = 'Destroy A Permission';
        $destroyPermission->description  = 'Destroy a permission';
        $destroyPermission->save();

        // 查看权限列表
        $indexPermission = new Permission();
        $indexPermission->name         = 'permission-index';
        $indexPermission->display_name = 'Show All Permissions';
        $indexPermission->description  = 'show all permissions';
        $indexPermission->save();

        // 创建角色
        $createRole = new Permission();
        $createRole->name         = 'role-store';
        $createRole->display_name = 'Create Role';
        $createRole->description  = 'create new role';
        $createRole->save();

        // 查看角色详情
        $showRole = new Permission();
        $showRole->name         = 'role-show';
        $showRole->display_name = 'Show Role';
        $showRole->description  = 'show a role';
        $showRole->save();

        // 查看角色列表
        $indexRole = new Permission();
        $indexRole->name         = 'role-index';
        $indexRole->display_name = 'Show All Roles';
        $indexRole->description  = 'show all roles';
        $indexRole->save();

        // 修改角色详情
        $updateRole = new Permission();
        $updateRole->name         = 'role-update';
        $updateRole->display_name = 'Update A Role';
        $updateRole->description  = 'update a role';
        $updateRole->save();

        // 删除角色
        $destroyRole = new Permission();
        $destroyRole->name         = 'role-destroy';
        $destroyRole->display_name = 'Destroy A Role';
        $destroyRole->description  = 'Destroy a role';
        $destroyRole->save();

        // 查看用户列表
        $showUser = new Permission();
        $showUser->name         = 'user-index';
        $showUser->display_name = 'Show All Users';
        $showUser->description  = 'Show All Users';
        $showUser->save();

        // 修改用户详情
        $updateUser = new Permission();
        $updateUser->name         = 'user-update';
        $updateUser->display_name = 'Update A User';
        $updateUser->description  = 'Update A User';
        $updateUser->save();

        // 删除用户
        $destroyUser = new Permission();
        $destroyUser->name         = 'user-destroy';
        $destroyUser->display_name = 'Destroy A User';
        $destroyUser->description  = 'Destroy A User';
        $destroyUser->save();

        // 查看消息列表
        $indexMessage = new Permission();
        $indexMessage->name         = 'message-index';
        $indexMessage->display_name = 'Show All Message';
        $indexMessage->description  = 'Show All Message';
        $indexMessage->save();

        // 创建消息
        $storeMessage = new Permission();
        $storeMessage->name         = 'message-store';
        $storeMessage->display_name = 'Create Message';
        $storeMessage->description  = 'Create Message';
        $storeMessage->save();

        // 查看消息详情
        $showMessage = new Permission();
        $showMessage->name         = 'message-show';
        $showMessage->display_name = 'Show A Message';
        $showMessage->description  = 'Show A Message';
        $showMessage->save();

        // 删除消息
        $destroyMessage = new Permission();
        $destroyMessage->name         = 'message-destroy';
        $destroyMessage->display_name = 'Destroy A Message';
        $destroyMessage->description  = 'Destroy A Message';
        $destroyMessage->save();

        // 查看通知列表
        $indexNotification = new Permission();
        $indexNotification->name         = 'notification-index';
        $indexNotification->display_name = 'Show All Notification';
        $indexNotification->description  = 'Show All Notification';
        $indexNotification->save();

        // 创建通知
        $storeNotification = new Permission();
        $storeNotification->name         = 'notification-store';
        $storeNotification->display_name = 'Create Notification';
        $storeNotification->description  = 'Create Notification';
        $storeNotification->save();

        // 查看通知详情
        $showNotification = new Permission();
        $showNotification->name         = 'notification-show';
        $showNotification->display_name = 'Show A Notification';
        $showNotification->description  = 'Show A Notification';
        $showNotification->save();

        // 更新通知
        $updateNotification = new Permission();
        $updateNotification->name         = 'notification-update';
        $updateNotification->display_name = 'Update A Notification';
        $updateNotification->description  = 'Update A Notification';
        $updateNotification->save();

        // 删除通知
        $destroyNotification = new Permission();
        $destroyNotification->name         = 'notification-destroy';
        $destroyNotification->display_name = 'Destroy A Notification';
        $destroyNotification->description  = 'Destroy A Notification';
        $destroyNotification->save();

        // 创建课程
        $indexCourse = new Permission();
        $indexCourse->name         = 'course-index';
        $indexCourse->display_name = 'All Course';
        $indexCourse->description  = 'All Course';
        $indexCourse->save();

        // 创建课程
        $storeCourse = new Permission();
        $storeCourse->name         = 'course-store';
        $storeCourse->display_name = 'Create Course';
        $storeCourse->description  = 'Create Course';
        $storeCourse->save();

        // 查看课程详情
        $showCourse = new Permission();
        $showCourse->name         = 'course-show';
        $showCourse->display_name = 'Show A Course';
        $showCourse->description  = 'Show A Course';
        $showCourse->save();

        // 编辑课程
        $updateCourse = new Permission();
        $updateCourse->name         = 'course-update';
        $updateCourse->display_name = 'Update A Course';
        $updateCourse->description  = 'Update A Course';
        $updateCourse->save();

        // 删除课程
        $destroyCourse = new Permission();
        $destroyCourse->name         = 'course-destroy';
        $destroyCourse->display_name = 'Destroy A Course';
        $destroyCourse->description  = 'Destroy A Course';
        $destroyCourse->save();

        // 全部组织
        $indexOrganization = new Permission();
        $indexOrganization->name         = 'organization-index';
        $indexOrganization->display_name = 'All Organization';
        $indexOrganization->description  = 'All Organization';
        $indexOrganization->save();

        // 创建组织
        $storeOrganization = new Permission();
        $storeOrganization->name         = 'organization-store';
        $storeOrganization->display_name = 'Create Organization';
        $storeOrganization->description  = 'Create Organization';
        $storeOrganization->save();

        // 查看组织详情
        $showOrganization = new Permission();
        $showOrganization->name         = 'organization-show';
        $showOrganization->display_name = 'Show A Organization';
        $showOrganization->description  = 'Show A Organization';
        $showOrganization->save();

        // 删除组织
        $destroyOrganization = new Permission();
        $destroyOrganization->name         = 'organization-destroy';
        $destroyOrganization->display_name = 'Destroy A Organization';
        $destroyOrganization->description  = 'Destroy A Organization';
        $destroyOrganization->save();


        // 全部讲课
        $allLecture = new Permission();
        $allLecture->name         = 'lecture-index';
        $allLecture->display_name = 'All Lecture';
        $allLecture->description  = 'All Lecture';
        $allLecture->save();

        // 创建讲课
        $storeLecture = new Permission();
        $storeLecture->name         = 'lecture-store';
        $storeLecture->display_name = 'Create Lecture';
        $storeLecture->description  = 'Create Lecture';
        $storeLecture->save();

        // 查看讲课详情
        $showLecture = new Permission();
        $showLecture->name         = 'lecture-show';
        $showLecture->display_name = 'Show A Lecture';
        $showLecture->description  = 'Show A Lecture';
        $showLecture->save();

        // 删除讲课
        $destroyLecture = new Permission();
        $destroyLecture->name         = 'lecture-destroy';
        $destroyLecture->display_name = 'Destroy A Lecture';
        $destroyLecture->description  = 'Destroy A Lecture';
        $destroyLecture->save();

        // 全部题目
        $indexquestion = new Permission();
        $indexquestion->name         = 'question-index';
        $indexquestion->display_name = 'All Question';
        $indexquestion->description  = 'All Question';
        $indexquestion->save();

        // 创建题目
        $storeQuestion = new Permission();
        $storeQuestion->name         = 'question-store';
        $storeQuestion->display_name = 'Create Question';
        $storeQuestion->description  = 'Create Question';
        $storeQuestion->save();

        // 查看题目
        $showQuestion = new Permission();
        $showQuestion->name         = 'question-show';
        $showQuestion->display_name = 'Show A Question';
        $showQuestion->description  = 'Show A Question';
        $showQuestion->save();

        // 编辑题目
        $updateQuestion = new Permission();
        $updateQuestion->name         = 'question-update';
        $updateQuestion->display_name = 'Update A Question';
        $updateQuestion->description  = 'Update A Question';
        $updateQuestion->save();

        // 删除题目
        $destroyQuestion = new Permission();
        $destroyQuestion->name         = 'question-destroy';
        $destroyQuestion->display_name = 'Destroy A Question';
        $destroyQuestion->description  = 'Destroy A Question';
        $destroyQuestion->save();

        // 全部试卷
        $indexPaper = new Permission();
        $indexPaper->name         = 'paper-index';
        $indexPaper->display_name = 'All Question';
        $indexPaper->description  = 'All Question';
        $indexPaper->save();

        // 创建试卷
        $storePaper = new Permission();
        $storePaper->name         = 'paper-store';
        $storePaper->display_name = 'Create Paper';
        $storePaper->description  = 'Create Paper';
        $storePaper->save();

        // 查看试卷
        $showPaper = new Permission();
        $showPaper->name         = 'paper-show';
        $showPaper->display_name = 'Show A Paper';
        $showPaper->description  = 'Show A Paper';
        $showPaper->save();

        // 编辑试卷
        $updatePaper = new Permission();
        $updatePaper->name         = 'paper-update';
        $updatePaper->display_name = 'Update A Paper';
        $updatePaper->description  = 'Update A Paper';
        $updatePaper->save();

        // 删除试卷
        $destroyQuestion = new Permission();
        $destroyQuestion->name         = 'paper-destroy';
        $destroyQuestion->display_name = 'Destroy A Paper';
        $destroyQuestion->description  = 'Destroy A Paper';
        $destroyQuestion->save();

        // 全部申请
        $indexApplication = new Permission();
        $indexApplication->name         = 'application-index';
        $indexApplication->display_name = 'All Application';
        $indexApplication->description  = 'All Application';
        $indexApplication->save();

        // 创建申请
        $storeApplication = new Permission();
        $storeApplication->name         = 'application-store';
        $storeApplication->display_name = 'Create Application';
        $storeApplication->description  = 'Create Application';
        $storeApplication->save();

        // 查看申请
        $showApplication = new Permission();
        $showApplication->name         = 'application-show';
        $showApplication->display_name = 'Show A Application';
        $showApplication->description  = 'Show A Application';
        $showApplication->save();

        // 同意申请
        $acceptApplication = new Permission();
        $acceptApplication->name         = 'application-accept';
        $acceptApplication->display_name = 'Accept A Application';
        $acceptApplication->description  = 'Accept A Application';
        $acceptApplication->save();

        // 拒绝申请
        $rejectApplication = new Permission();
        $rejectApplication->name         = 'application-reject';
        $rejectApplication->display_name = 'Reject A Application';
        $rejectApplication->description  = 'Reject A Application';
        $rejectApplication->save();

        // 删除申请
        $destroyApplication = new Permission();
        $destroyApplication->name         = 'application-destroy';
        $destroyApplication->display_name = 'Destroy A Application';
        $destroyApplication->description  = 'Destroy A Application';
        $destroyApplication->save();

        // 全部标签
        $indexTag = new Permission();
        $indexTag->name         = 'tag-index';
        $indexTag->display_name = 'All Tag';
        $indexTag->description  = 'All Tag';
        $indexTag->save();

        // 查看标签
        $showTag = new Permission();
        $showTag->name         = 'tag-show';
        $showTag->display_name = 'Show A Tag';
        $showTag->description  = 'Show A Tag';
        $showTag->save();

        // 编辑标签
        $updateTag = new Permission();
        $updateTag->name         = 'tag-update';
        $updateTag->display_name = 'Update A Tag';
        $updateTag->description  = 'Update A Tag';
        $updateTag->save();

        // 删除标签
        $destroyTag = new Permission();
        $destroyTag->name         = 'tag-destroy';
        $destroyTag->display_name = 'Destroy A Tag';
        $destroyTag->description  = 'Destroy A Tag';
        $destroyTag->save();

        // 全部考试
        $indexExam = new Permission();
        $indexExam->name         = 'exam-index';
        $indexExam->display_name = 'All Exam';
        $indexExam->description  = 'All Exam';
        $indexExam->save();

        // 查看考试
        $showExam = new Permission();
        $showExam->name         = 'exam-show';
        $showExam->display_name = 'Show A Exam';
        $showExam->description  = 'Show A Exam';
        $showExam->save();

        // 添加考试
        $storeExam = new Permission();
        $storeExam->name         = 'exam-store';
        $storeExam->display_name = 'Store A Exam';
        $storeExam->description  = 'Store A Exam';
        $storeExam->save();

        // 编辑考试
        $updateExam = new Permission();
        $updateExam->name         = 'exam-update';
        $updateExam->display_name = 'Update A Exam';
        $updateExam->description  = 'Update A Exam';
        $updateExam->save();

        // 删除考试
        $destroyExam = new Permission();
        $destroyExam->name         = 'exam-destroy';
        $destroyExam->display_name = 'Destroy A Exam';
        $destroyExam->description  = 'Destroy A Exam';
        $destroyExam->save();

        // 全部问题类型
        $indexQuestionType = new Permission();
        $indexQuestionType->name         = 'questionType-index';
        $indexQuestionType->display_name = 'All QuestionType';
        $indexQuestionType->description  = 'All QuestionType';
        $indexQuestionType->save();

        // 查看问题类型
        $showQuestionType = new Permission();
        $showQuestionType->name         = 'questionType-show';
        $showQuestionType->display_name = 'Show A QuestionType';
        $showQuestionType->description  = 'Show A QuestionType';
        $showQuestionType->save();

        // 添加问题类型
        $storeQuestionType = new Permission();
        $storeQuestionType->name         = 'questionType-store';
        $storeQuestionType->display_name = 'Store A QuestionType';
        $storeQuestionType->description  = 'Store A QuestionType';
        $storeQuestionType->save();

        // 编辑问题类型
        $updateQuestionType = new Permission();
        $updateQuestionType->name         = 'questionType-update';
        $updateQuestionType->display_name = 'Update A QuestionType';
        $updateQuestionType->description  = 'Update A QuestionType';
        $updateQuestionType->save();

        // 删除问题类型
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'questionType-destroy';
        $destroyQuestionType->display_name = 'Destroy A QuestionType';
        $destroyQuestionType->description  = 'Destroy A QuestionType';
        $destroyQuestionType->save();

        // 新增课程视频
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'add-video';
        $destroyQuestionType->display_name = 'Add A Video Info';
        $destroyQuestionType->description  = 'Add A Video Info';
        $destroyQuestionType->save();

        // 新增课程文档
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'add-document';
        $destroyQuestionType->display_name = 'Add A Document Info';
        $destroyQuestionType->description  = 'Add A Document Info';
        $destroyQuestionType->save();

        // 获取视频材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'show-video';
        $destroyQuestionType->display_name = 'Show A Video Info';
        $destroyQuestionType->description  = 'Show A Video Info';
        $destroyQuestionType->save();

        // 获取文档材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'show-document';
        $destroyQuestionType->display_name = 'Show A Document Info';
        $destroyQuestionType->description  = 'Show A Document Info';
        $destroyQuestionType->save();

        // 删除视频材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'destroy-video';
        $destroyQuestionType->display_name = 'Destroy A Video Info';
        $destroyQuestionType->description  = 'Destroy A Video Info';
        $destroyQuestionType->save();

        // 删除文档材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'destroy-document';
        $destroyQuestionType->display_name = 'Destroy A Document Info';
        $destroyQuestionType->description  = 'Destroy A Document Info';
        $destroyQuestionType->save();

        // 编辑视频材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'update-video';
        $destroyQuestionType->display_name = 'Update A Video Info';
        $destroyQuestionType->description  = 'Update A Video Info';
        $destroyQuestionType->save();

        // 编辑文档材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'update-document';
        $destroyQuestionType->display_name = 'Update A Document Info';
        $destroyQuestionType->description  = 'Update A Document Info';
        $destroyQuestionType->save();

        // 新增课程视频
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'video-store';
        $destroyQuestionType->display_name = '上传一个视频材料并插入数据库';
        $destroyQuestionType->description  = '上传一个视频材料并插入数据库';
        $destroyQuestionType->save();

        // 新增课程文档
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'document-store';
        $destroyQuestionType->display_name = '上传一个文档材料并插入数据库';
        $destroyQuestionType->description  = '上传一个文档材料并插入数据库';
        $destroyQuestionType->save();

        // 获取全部视频材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'video-index';
        $destroyQuestionType->display_name = '查询全部视频材料';
        $destroyQuestionType->description  = '查询全部视频材料';
        $destroyQuestionType->save();


        // 获取文档材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'document-index';
        $destroyQuestionType->display_name = '查询全部文档材料';
        $destroyQuestionType->description  = '查询全部文档材料';
        $destroyQuestionType->save();

        // 删除视频材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'video-destroy';
        $destroyQuestionType->display_name = '删除视频材料';
        $destroyQuestionType->description  = '删除视频材料';
        $destroyQuestionType->save();

        // 删除文档材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'document-destroy';
        $destroyQuestionType->display_name = '删除文档材料';
        $destroyQuestionType->description  = '删除文档材料';
        $destroyQuestionType->save();

        // 编辑视频材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'video-update';
        $destroyQuestionType->display_name = '更新视频材料';
        $destroyQuestionType->description  = '更新视频材料';
        $destroyQuestionType->save();

        // 编辑文档材料
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'document-update';
        $destroyQuestionType->display_name = '更新文档材料';
        $destroyQuestionType->description  = '更新文档材料';
        $destroyQuestionType->save();

        // 新增预习

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'preview-store';
        $destroyQuestionType->display_name = '新增预习内容';
        $destroyQuestionType->description  = '新增预习内容';
        $destroyQuestionType->save();


        // 发布预习
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'preview-publish';
        $destroyQuestionType->display_name = '发布预习内容';
        $destroyQuestionType->description  = '发布预习内容';
        $destroyQuestionType->save();


        // 更新预习

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'preview-update';
        $destroyQuestionType->display_name = '更新预习内容';
        $destroyQuestionType->description  = '更新预习内容';
        $destroyQuestionType->save();

        // 删除预习

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'preview-destory';
        $destroyQuestionType->display_name = '删除预习内容';
        $destroyQuestionType->description  = '删除预习内容';
        $destroyQuestionType->save();



        // 查询全部预习

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'preview-index';
        $destroyQuestionType->display_name = '查询全部预习';
        $destroyQuestionType->description  = '查询全部预习';
        $destroyQuestionType->save();


        // 上传导入学生用户数据

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'import-student';
        $destroyQuestionType->display_name = '批量导入学生用户数据';
        $destroyQuestionType->description  = '批量导入学生用户数据';
        $destroyQuestionType->save();

        // 上传导入教师用户数据

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'import-teacher';
        $destroyQuestionType->display_name = '批量导入教师用户数据';
        $destroyQuestionType->description  = '批量导入教师用户数据';
        $destroyQuestionType->save();


        // 新增讨论话题

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'discuss-store';
        $destroyQuestionType->display_name = '发布讨论话题';
        $destroyQuestionType->description  = '发布讨论话题';
        $destroyQuestionType->save();


        // 修改讨论话题

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'discuss-destory';
        $destroyQuestionType->display_name = '删除讨论话题';
        $destroyQuestionType->description  = '删除讨论话题';
        $destroyQuestionType->save();

        // 删除讨论话题

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'discuss-update';
        $destroyQuestionType->display_name = '修改讨论话题';
        $destroyQuestionType->description  = '修改讨论话题';
        $destroyQuestionType->save();
    }
}
