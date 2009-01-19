
<!-- START USER INFO -->
<div class="user_info">
<h4>User Info</h4>
<p>Welcome back <strong><?php echo $user->username; ?></strong>!</p>
<ul>
	<li><?php echo html::anchor('#', 'Profile'); ?></li>
	<li><?php echo html::anchor('user/logout', 'Logout'); ?></li>
</ul>
</div>
<!-- END USER INFO -->