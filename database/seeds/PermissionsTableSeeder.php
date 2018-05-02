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
        $createPermission->display_name = '权限-添加';
        $createPermission->description  = '添加权限';
        $createPermission->save();

        // 查看权限详情
        $showPermission = new Permission();
        $showPermission->name         = 'permission-show';
        $showPermission->display_name = '权限-查看';
        $showPermission->description  = '查看权限详情';
        $showPermission->save();

        // 编辑权限
        $updatePermission = new Permission();
        $updatePermission->name         = 'permission-update';
        $updatePermission->display_name = '权限-编辑';
        $updatePermission->description  = '编辑权限';
        $updatePermission->save();

        // 删除权限
        $destroyPermission = new Permission();
        $destroyPermission->name         = 'permission-destroy';
        $destroyPermission->display_name = '权限-删除';
        $destroyPermission->description  = '删除权限';
        $destroyPermission->save();

        // 查看权限列表
        $indexPermission = new Permission();
        $indexPermission->name         = 'permission-index';
        $indexPermission->display_name = '权限-全部';
        $indexPermission->description  = '查看全部权限';
        $indexPermission->save();

        // 创建角色
        $createRole = new Permission();
        $createRole->name         = 'role-store';
        $createRole->display_name = '角色-添加';
        $createRole->description  = 'create new role';
        $createRole->save();

        // 查看角色详情
        $showRole = new Permission();
        $showRole->name         = 'role-show';
        $showRole->display_name = '角色-查看';
        $showRole->description  = '查看角色详情';
        $showRole->save();

        // 查看角色列表
        $indexRole = new Permission();
        $indexRole->name         = 'role-index';
        $indexRole->display_name = '角色-全部';
        $indexRole->description  = '查看全部角色';
        $indexRole->save();

        // 修改角色详情
        $updateRole = new Permission();
        $updateRole->name         = 'role-update';
        $updateRole->display_name = '角色-编辑';
        $updateRole->description  = '编辑角色';
        $updateRole->save();

        // 删除角色
        $destroyRole = new Permission();
        $destroyRole->name         = 'role-destroy';
        $destroyRole->display_name = '角色-删除';
        $destroyRole->description  = '删除角色';
        $destroyRole->save();

        // 查看用户列表
        $showUser = new Permission();
        $showUser->name         = 'user-index';
        $showUser->display_name = '用户-全部';
        $showUser->description  = '查看全部用户';
        $showUser->save();

        // 修改用户详情
        $updateUser = new Permission();
        $updateUser->name         = 'user-update';
        $updateUser->display_name = '用户-编辑';
        $updateUser->description  = '编辑用户';
        $updateUser->save();

        // 删除用户
        $destroyUser = new Permission();
        $destroyUser->name         = 'user-destroy';
        $destroyUser->display_name = '用户-删除';
        $destroyUser->description  = '删除用户';
        $destroyUser->save();

        // 查看消息列表
        $indexMessage = new Permission();
        $indexMessage->name         = 'message-index';
        $indexMessage->display_name = '消息-全部';
        $indexMessage->description  = '查看全部消息';
        $indexMessage->save();

        // 创建消息
        $storeMessage = new Permission();
        $storeMessage->name         = 'message-store';
        $storeMessage->display_name = '消息-添加';
        $storeMessage->description  = '添加消息';
        $storeMessage->save();

        // 查看消息详情
        $showMessage = new Permission();
        $showMessage->name         = 'message-show';
        $showMessage->display_name = '消息-查看';
        $showMessage->description  = '查看消息详情';
        $showMessage->save();

        // 删除消息
        $destroyMessage = new Permission();
        $destroyMessage->name         = 'message-destroy';
        $destroyMessage->display_name = '消息-删除';
        $destroyMessage->description  = '删除消息';
        $destroyMessage->save();

        // 查看通知列表
        $indexNotification = new Permission();
        $indexNotification->name         = 'notification-index';
        $indexNotification->display_name = '通知-全部';
        $indexNotification->description  = '查看全部通知';
        $indexNotification->save();

        // 创建通知
        $storeNotification = new Permission();
        $storeNotification->name         = 'notification-store';
        $storeNotification->display_name = '通知-添加';
        $storeNotification->description  = '添加通知';
        $storeNotification->save();

        // 查看通知详情
        $showNotification = new Permission();
        $showNotification->name         = 'notification-show';
        $showNotification->display_name = '通知-查看';
        $showNotification->description  = '查看通知';
        $showNotification->save();

        // 更新通知
        $updateNotification = new Permission();
        $updateNotification->name         = 'notification-update';
        $updateNotification->display_name = '通知-编辑';
        $updateNotification->description  = '编辑通知';
        $updateNotification->save();

        // 删除通知
        $destroyNotification = new Permission();
        $destroyNotification->name         = 'notification-destroy';
        $destroyNotification->display_name = '通知-删除';
        $destroyNotification->description  = '删除通知';
        $destroyNotification->save();

        // 创建课程
        $indexCourse = new Permission();
        $indexCourse->name         = 'course-index';
        $indexCourse->display_name = '课程-全部';
        $indexCourse->description  = '查看全部课程';
        $indexCourse->save();

        // 创建课程
        $storeCourse = new Permission();
        $storeCourse->name         = 'course-store';
        $storeCourse->display_name = '课程-添加';
        $storeCourse->description  = '添加课程';
        $storeCourse->save();

        // 查看课程详情
        $showCourse = new Permission();
        $showCourse->name         = 'course-show';
        $showCourse->display_name = '课程-查看';
        $showCourse->description  = '查看课程详情';
        $showCourse->save();

        // 编辑课程
        $updateCourse = new Permission();
        $updateCourse->name         = 'course-update';
        $updateCourse->display_name = '课程-编辑';
        $updateCourse->description  = '编辑课程';
        $updateCourse->save();

        // 删除课程
        $destroyCourse = new Permission();
        $destroyCourse->name         = 'course-destroy';
        $destroyCourse->display_name = '课程-删除';
        $destroyCourse->description  = '删除课程';
        $destroyCourse->save();

        // 全部组织
        $indexOrganization = new Permission();
        $indexOrganization->name         = 'organization-index';
        $indexOrganization->display_name = '组织-全部';
        $indexOrganization->description  = '查看全部组织';
        $indexOrganization->save();

        // 创建组织
        $storeOrganization = new Permission();
        $storeOrganization->name         = 'organization-store';
        $storeOrganization->display_name = '组织-添加';
        $storeOrganization->description  = '添加组织';
        $storeOrganization->save();

        // 查看组织详情
        $showOrganization = new Permission();
        $showOrganization->name         = 'organization-show';
        $showOrganization->display_name = '组织-查看';
        $showOrganization->description  = '查看组织详情';
        $showOrganization->save();

        // 删除组织
        $destroyOrganization = new Permission();
        $destroyOrganization->name         = 'organization-destroy';
        $destroyOrganization->display_name = '组织-删除';
        $destroyOrganization->description  = '删除组织';
        $destroyOrganization->save();


        // 全部讲课
        $allLecture = new Permission();
        $allLecture->name         = 'lecture-index';
        $allLecture->display_name = '授课-全部';
        $allLecture->description  = '查看全部授课';
        $allLecture->save();

        // 创建讲课
        $storeLecture = new Permission();
        $storeLecture->name         = 'lecture-store';
        $storeLecture->display_name = '授课-添加';
        $storeLecture->description  = '添加授课';
        $storeLecture->save();

        // 查看讲课详情
        $showLecture = new Permission();
        $showLecture->name         = 'lecture-show';
        $showLecture->display_name = '授课-查看';
        $showLecture->description  = '查看授课详情';
        $showLecture->save();

        // 删除讲课
        $destroyLecture = new Permission();
        $destroyLecture->name         = 'lecture-destroy';
        $destroyLecture->display_name = '授课-删除';
        $destroyLecture->description  = '删除授课';
        $destroyLecture->save();

        // 全部题目
        $indexquestion = new Permission();
        $indexquestion->name         = 'question-index';
        $indexquestion->display_name = '题目-全部';
        $indexquestion->description  = '查看全部题目';
        $indexquestion->save();

        // 创建题目
        $storeQuestion = new Permission();
        $storeQuestion->name         = 'question-store';
        $storeQuestion->display_name = '题目-添加';
        $storeQuestion->description  = '添加题目';
        $storeQuestion->save();

        // 查看题目
        $showQuestion = new Permission();
        $showQuestion->name         = 'question-show';
        $showQuestion->display_name = '题目-查看';
        $showQuestion->description  = '查看题目详情';
        $showQuestion->save();

        // 编辑题目
        $updateQuestion = new Permission();
        $updateQuestion->name         = 'question-update';
        $updateQuestion->display_name = '题目-编辑';
        $updateQuestion->description  = '编辑题目';
        $updateQuestion->save();

        // 删除题目
        $destroyQuestion = new Permission();
        $destroyQuestion->name         = 'question-destroy';
        $destroyQuestion->display_name = '题目-删除';
        $destroyQuestion->description  = '删除题目';
        $destroyQuestion->save();

        // 全部试卷
        $indexPaper = new Permission();
        $indexPaper->name         = 'paper-index';
        $indexPaper->display_name = '试卷-全部';
        $indexPaper->description  = '查看全部试卷';
        $indexPaper->save();

        // 创建试卷
        $storePaper = new Permission();
        $storePaper->name         = 'paper-store';
        $storePaper->display_name = '试卷-添加';
        $storePaper->description  = '添加试卷';
        $storePaper->save();

        // 查看试卷
        $showPaper = new Permission();
        $showPaper->name         = 'paper-show';
        $showPaper->display_name = '试卷-查看';
        $showPaper->description  = '查看试卷';
        $showPaper->save();

        // 编辑试卷
        $updatePaper = new Permission();
        $updatePaper->name         = 'paper-update';
        $updatePaper->display_name = '试卷-编辑';
        $updatePaper->description  = '编辑试卷';
        $updatePaper->save();

        // 删除试卷
        $destroyQuestion = new Permission();
        $destroyQuestion->name         = 'paper-destroy';
        $destroyQuestion->display_name = '试卷-删除';
        $destroyQuestion->description  = '删除试卷';
        $destroyQuestion->save();

        // 全部申请
        $indexApplication = new Permission();
        $indexApplication->name         = 'application-index';
        $indexApplication->display_name = '申请-全部';
        $indexApplication->description  = '查看全部申请';
        $indexApplication->save();

        // 创建申请
        $storeApplication = new Permission();
        $storeApplication->name         = 'application-store';
        $storeApplication->display_name = '申请-添加';
        $storeApplication->description  = '添加申请';
        $storeApplication->save();

        // 查看申请
        $showApplication = new Permission();
        $showApplication->name         = 'application-show';
        $showApplication->display_name = '申请-查看';
        $showApplication->description  = '查看申请详情';
        $showApplication->save();

        // 同意申请
        $acceptApplication = new Permission();
        $acceptApplication->name         = 'application-accept';
        $acceptApplication->display_name = '申请-接受';
        $acceptApplication->description  = '接受申请';
        $acceptApplication->save();

        // 拒绝申请
        $rejectApplication = new Permission();
        $rejectApplication->name         = 'application-reject';
        $rejectApplication->display_name = '申请-拒绝';
        $rejectApplication->description  = '拒绝申请';
        $rejectApplication->save();

        // 删除申请
        $destroyApplication = new Permission();
        $destroyApplication->name         = 'application-destroy';
        $destroyApplication->display_name = '申请-删除';
        $destroyApplication->description  = '删除申请';
        $destroyApplication->save();

        // 全部标签
        $indexTag = new Permission();
        $indexTag->name         = 'tag-index';
        $indexTag->display_name = '标签-全部';
        $indexTag->description  = '查看全部标签';
        $indexTag->save();

        // 查看标签
        $showTag = new Permission();
        $showTag->name         = 'tag-show';
        $showTag->display_name = '标签-查看';
        $showTag->description  = '查看标签详情';
        $showTag->save();

        // 编辑标签
        $updateTag = new Permission();
        $updateTag->name         = 'tag-update';
        $updateTag->display_name = '标签-编辑';
        $updateTag->description  = '编辑标签';
        $updateTag->save();

        // 删除标签
        $destroyTag = new Permission();
        $destroyTag->name         = 'tag-destroy';
        $destroyTag->display_name = '标签-删除';
        $destroyTag->description  = '删除标签';
        $destroyTag->save();

        // 全部考试
        $indexExam = new Permission();
        $indexExam->name         = 'exam-index';
        $indexExam->display_name = '考试-全部';
        $indexExam->description  = '查看全部考试';
        $indexExam->save();

        // 查看考试
        $showExam = new Permission();
        $showExam->name         = 'exam-show';
        $showExam->display_name = '考试-查看';
        $showExam->description  = '查看考试详情';
        $showExam->save();

        // 添加考试
        $storeExam = new Permission();
        $storeExam->name         = 'exam-store';
        $storeExam->display_name = '考试-添加';
        $storeExam->description  = '添加考试';
        $storeExam->save();

        // 编辑考试
        $updateExam = new Permission();
        $updateExam->name         = 'exam-update';
        $updateExam->display_name = '考试-编辑';
        $updateExam->description  = '编辑考试';
        $updateExam->save();

        // 删除考试
        $destroyExam = new Permission();
        $destroyExam->name         = 'exam-destroy';
        $destroyExam->display_name = '考试-删除';
        $destroyExam->description  = '删除考试';
        $destroyExam->save();

        // 全部问题类型
        $indexQuestionType = new Permission();
        $indexQuestionType->name         = 'questionType-index';
        $indexQuestionType->display_name = '问题类型-全部';
        $indexQuestionType->description  = '查看全部问题类型';
        $indexQuestionType->save();

        // 查看问题类型
        $showQuestionType = new Permission();
        $showQuestionType->name         = 'questionType-show';
        $showQuestionType->display_name = '问题类型-查看';
        $showQuestionType->description  = '查看问题类型详情';
        $showQuestionType->save();

        // 添加问题类型
        $storeQuestionType = new Permission();
        $storeQuestionType->name         = 'questionType-store';
        $storeQuestionType->display_name = '问题类型-添加';
        $storeQuestionType->description  = '添加问题类型';
        $storeQuestionType->save();

        // 编辑问题类型
        $updateQuestionType = new Permission();
        $updateQuestionType->name         = 'questionType-update';
        $updateQuestionType->display_name = '问题类型-编辑';
        $updateQuestionType->description  = '编辑问题类型';
        $updateQuestionType->save();

        // 删除问题类型
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'questionType-destroy';
        $destroyQuestionType->display_name = '问题类型-删除';
        $destroyQuestionType->description  = '删除问题类型';
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

        // 上传问题

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'import-question';
        $destroyQuestionType->display_name = '教师批量导入问题数据';
        $destroyQuestionType->description  = '教师批量导入问题数据';
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


        // 查询当前用户发布的讨论话题

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'discuss-userid-show';
        $destroyQuestionType->display_name = '查询当前用户发布的讨论话题';
        $destroyQuestionType->description  = '查询当前用户发布的讨论话题';
        $destroyQuestionType->save();

        // 查询当前课程的讨论话题

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'discuss-lid-show';
        $destroyQuestionType->display_name = '查询当前课程的讨论话题';
        $destroyQuestionType->description  = '查询当前课程的讨论话题';
        $destroyQuestionType->save();

        // 查询所有的讨论话题

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'discuss-index';
        $destroyQuestionType->display_name = '查询所有的讨论话题';
        $destroyQuestionType->description  = '查询所有的讨论话题';
        $destroyQuestionType->save();

        // 查询某个话题下的回复和讨论话题

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'discuss-reply-show';
        $destroyQuestionType->display_name = '查询某个话题下的回复和讨论话题';
        $destroyQuestionType->description  = '查询某个话题下的回复和讨论话题';
        $destroyQuestionType->save();

        // 回复某个讨论话题

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'discuss-reply-store';
        $destroyQuestionType->display_name = '回复某个讨论话题';
        $destroyQuestionType->description  = '回复某个讨论话题';
        $destroyQuestionType->save();

        // 删除某个讨论话题的回复

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'discuss-reply-destory';
        $destroyQuestionType->display_name = '删除某个讨论话题的回复';
        $destroyQuestionType->description  = '删除某个讨论话题的回复';
        $destroyQuestionType->save();

        // 查询当前用户某个话题的回复

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'reply-userid-show';
        $destroyQuestionType->display_name = '查询当前用户某个话题的回复';
        $destroyQuestionType->description  = '查询当前用户某个话题的回复';
        $destroyQuestionType->save();

        // 查询当前用户某个课程的回复

        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'reply-userid-show';
        $destroyQuestionType->display_name = '查询当前用户某个课程的回复';
        $destroyQuestionType->description  = '查询当前用户某个课程的回复';
        $destroyQuestionType->save();

        // 查询所有用户的回复
        $destroyQuestionType = new Permission();
        $destroyQuestionType->name         = 'reply-userid-show';
        $destroyQuestionType->display_name = '查询所有用户的回复';
        $destroyQuestionType->description  = '查询所有用户的回复';
        $destroyQuestionType->save();







    }


}
