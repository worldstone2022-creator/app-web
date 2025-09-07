<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Http\Requests\Discussion\StoreRequest;
use App\Models\Discussion;
use App\Models\DiscussionCategory;
use App\Models\DiscussionReply;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Helper\UserService;

class DiscussionController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('modules.projects.discussion');
    }

    public function create()
    {
        $this->addPermission = user()->permission('add_project_discussions');
        $this->projectId = request('id');
        $project = Project::findOrFail($this->projectId);
        $userId = UserService::getUserId();

        $userData = [];
        $usersData = $project->projectMembers;

        foreach ($usersData as $user) {

            $url = route('employees.show', [$user->id]);

            $userData[] = ['id' => $user->id, 'value' => $user->name, 'image' => $user->image_url, 'link' => $url];

        }

        $this->userData = $userData;
        abort_403(!(in_array($this->addPermission, ['all', 'added']) || $project->project_admin == $userId));

        $this->categories = DiscussionCategory::orderBy('order', 'asc')->get();
        $this->redirectUrl = request('redirectUrl');

        return view('discussions.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        $discussion = new Discussion();
        $discussion->title = $request->title;
        $discussion->discussion_category_id = $request->discussion_category;
        $userId = UserService::getUserId();

        if (request()->has('project_id')) {
            $discussion->project_id = $request->project_id;
        }

        $discussion->last_reply_at = now()->timezone('UTC')->toDateTimeString();
        $discussion->user_id = $userId;
        $discussion->save();

        $discussionReply = DiscussionReply::create(
            [
                'body' => $request->description,
                'user_id' => $userId,
                'discussion_id' => $discussion->id,
                'added_by' => user()->id
            ]
        );

        $redirectUrl = urldecode($request->redirect_url);

        if ($redirectUrl == '') {
            $redirectUrl = route('projects.index');
        }

        return Reply::successWithData(__('messages.recordSaved'), ['discussion_id' => $discussion->id, 'discussion_reply_id' => $discussionReply->id, 'redirectUrl' => $redirectUrl]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function show($id)
    {
        $this->discussion = Discussion::with('category', 'replies', 'replies.user', 'replies.files')->findOrFail($id);
        $viewPermission = user()->permission('view_project_discussions');
        $this->userId = UserService::getUserId();
        abort_403(!($viewPermission == 'all' || ($viewPermission == 'added' && $this->discussion->added_by == $this->userId)));

        $project = Project::findOrFail($this->discussion->project_id);

        $userData = [];
        $usersData = $project->projectMembers;

        foreach ($usersData as $user) {

            $url = route('employees.show', [$user->id]);

            $userData[] = ['id' => $user->id, 'value' => $user->name, 'image' => $user->image_url, 'link' => $url];
        }

        $this->userData = $userData;
        $this->userRoles = user()->roles->pluck('name')->toArray();
        $this->view = 'discussions.replies.show';

        if (request()->ajax()) {
            return $this->returnAjax($this->view);
        }

        return redirect(route('projects.show', $this->discussion->project_id) . '?tab=discussion');
    }

    public function destroy($id)
    {
        $this->discussion = Discussion::with('category', 'replies', 'replies.user', 'replies.files')->findOrFail($id);
        $deletePermission = user()->permission('delete_project_discussions');
        $userId = UserService::getUserId();
        abort_403(!($deletePermission == 'all' || ($deletePermission == 'added' && $this->discussion->added_by == $userId)));

        Discussion::destroy($id);
        return Reply::success(__('messages.deleteSuccess'));
    }

    public function setBestAnswer(Request $request)
    {
        $userId = UserService::getUserId();
        $reply = DiscussionReply::findOrFail($request->replyId);
        $editPermission = user()->permission('edit_project_discussions');
        abort_403(!($editPermission == 'all' || ($editPermission == 'added' && $reply->discussion->added_by == $userId)));

        $replyId = ($request->type == 'set') ? $request->replyId : null;
        Discussion::where('id', $reply->discussion_id)
            ->update(['best_answer_id' => $replyId]);
        $this->discussion = Discussion::with('category', 'replies', 'replies.user', 'replies.files')->findOrFail($reply->discussion_id);


        $userData = [];
        $usersData = $reply->discussion->project->projectMembers;

        foreach ($usersData as $user) {

            $url = route('employees.show', [$user->id]);

            $userData[] = ['id' => $user->id, 'value' => $user->name, 'image' => $user->image_url, 'link' => $url];
        }

        $this->userData = $userData;
        $this->userRoles = user()->roles->pluck('name')->toArray();
        return $this->returnAjax('discussions.replies.show');

    }

}
