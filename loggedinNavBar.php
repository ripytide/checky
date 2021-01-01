<nav class="navbar navbar-expand-md navbar-light">
	<div class="container-fluid">
		<a class="navbar-brand fw-bold mx-3" href="/">Checky</a>
		<button
			class="navbar-toggler"
			type="button"
			data-bs-toggle="collapse"
			data-bs-target="#myNavBar"
		>
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="myNavBar">
			<ul class="navbar-nav">
				<li class="nav-item mx-2">
					<a class="nav-link fw-bold" href="/">Home</a>
				</li>
			</ul>
		</div>

		<div class="collapse navbar-collapse justify-content-end" id="myNavBar">
			<ul class="navbar-nav">
                <li class="nav-item mx-2">
					<a class="nav-link fw-bold" href="/mychecklists"><?php echo($_SESSION["username"]);?></a>
				</li>
				<li class="nav-item mx-2">
					<a class="nav-link fw-bold" href="/logout">Logout</a>
				</li>
				<li class="nav-item mx-2">
					<a class="nav-link fw-bold" href="/createChecklist">Create a Checklist</a>
				</li>
			</ul>
		</div>
	</div>
</nav>


