<?php if ($loggedIn): ?>
<li>
   <a href="/mychecklists">My Checklists</a>
</li>
<li>
   <a href="/mychecklists"><?php echo($_SESSION["username"]);?></a>
</li>
<li>
   <a href="/logout">Logout</a>
</li>
<li>
   <a href="/createChecklist">Create a Checklist</a>
</li>
<?php else: ?>
<li>
   <a href="/login">Login</a>
</li>
<li>
   <a href="/register">Register</a>
</li>
<li>
   <a href="/createChecklist"
      >Create a Checklist</a
   >
</li>
<?php endif; ?>