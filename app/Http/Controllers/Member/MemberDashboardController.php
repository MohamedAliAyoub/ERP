<?php

namespace App\Http\Controllers\Member;

use App\Attendance;
use App\AttendanceSetting;
use App\EmployeeDetails;
use App\EmployeeDocs;
use App\Holiday;
use App\LanguageSetting;
use App\Leave;
use App\LeaveType;
use App\Notice;
use App\Project;
use App\ProjectActivity;
use App\ProjectTimeLog;
use App\Task;
use App\TaskboardColumn;
use App\User;
use App\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MemberDashboardController extends MemberBaseController
{

    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = 'app.menu.dashboard';
        $this->pageIcon = 'icon-speedometer';
    }

    public function index()
    {

        $id = auth()->id();
        $this->employee = User::with(['employeeDetail', 'employeeDetail.designation', 'employeeDetail.department', 'leaveTypes'])->withoutGlobalScope('active')->findOrFail($id);
        $this->employeeDetail = EmployeeDetails::where('user_id', '=', $this->employee->id)->first();
        $this->employeeDocs = EmployeeDocs::where('user_id', '=', $this->employee->id)->get();
        if (!is_null($this->employeeDetail)) {
            $this->employeeDetail = $this->employeeDetail->withCustomFields();
            $this->fields = $this->employeeDetail->getCustomFieldGroupsWithFields()->fields;
        }

        $completedTaskColumn = TaskboardColumn::where('slug', 'completed')->first();

        $this->taskCompleted = Task::join('task_users', 'task_users.task_id', '=', 'tasks.id')
            ->where('task_users.user_id', $id)
            ->where('tasks.board_column_id', $completedTaskColumn->id)
            ->count();

        $hoursLogged = ProjectTimeLog::where('user_id', $id)->sum('total_minutes');

        $timeLog = intdiv($hoursLogged, 60) . ' hrs ';

        if (($hoursLogged % 60) > 0) {
            $timeLog .= ($hoursLogged % 60) . ' mins';
        }

        $this->hoursLogged = $timeLog;

        $this->activities = UserActivity::where('user_id', $id)->orderBy('id', 'desc')->get();
        $this->projects = Project::select('projects.id', 'projects.project_name', 'projects.deadline', 'projects.completion_percent')
            ->join('project_members', 'project_members.project_id', '=', 'projects.id')
            ->where('project_members.user_id', '=', $id)
            ->get();
        $this->leaves = Leave::byUser($id);
        $this->leavesCount = Leave::byUserCount($id);

        $this->leaveTypes = LeaveType::byUser($id);
        $this->allowedLeaves = $this->employee->leaveTypes->sum('no_of_leaves');
        $this->employeeLeavesQuota = $this->employee->leaveTypes;


        return view('member.dashboard.index-info', $this->data);
    }

}
