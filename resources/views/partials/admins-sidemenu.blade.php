@can('issuperadmin')
<li><div class="divider"></div></li>
<li><a class="subheader blue-text" href="#"><small>Super Admin Options</small></a></li>
<li id="manage-users"><a class="waves-effect" href=" {{ route('admins.manage-users') }} ">Manage Users</a></li>
<li id="approve-accounts"><a class="waves-effect" href=" {{ route('admins.approve-accounts') }} ">Approve Provider Accounts</a></li>
@endcan
@can('isadmin')
<li><div class="divider"></div></li>
<li><a class="subheader blue-text" href="#"><small>Admin Options</small></a></li>
<li id="manage-service-types"><a class="waves-effect" href=" {{ route('admins.manage-service-types') }} ">Manage Service Types</a></li>
<li id="manage-users"><a class="waves-effect" href="#">Queries</a></li>
@endcan
