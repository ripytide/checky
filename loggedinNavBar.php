<nav class="navbar">
	<div>
		<a href="/">Checky</a>
		<button
			type="button"
			data-bs-toggle="collapse"
			data-bs-target="#myNavBar"
		>
		</button>

		<div id="myNavBar">
			<ul>
				<li">
					<a href="/">Home</a>
				</li>
			</ul>
		</div>

		<div id="myNavBar">
			<ul>
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
					<a href="/register">Register</a>
				</li>
				<li>
					<a href="/createChecklist"
						>Create a Checklist</a
					>
				</li>
			</ul>
		</div>
	</div>
</nav>


