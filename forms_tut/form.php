<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    var_dump($_POST);

}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Forms</title>
    <meta charset="utf-8">
</head>
<body>

<form method="post">

    <div>
        text: <input type="text" name="surname" value="Bloggs">
    </div>

    <div>
        password: <input type="password" name="password">
    </div>

    <div>
        tel: <input type="tel" name="telephone">
    </div>

    <div>
        url: <input type="url" name="web_address">
    </div>

    <div>
        date: <input type="date" name="date">
    </div>

    <div>
        time: <input type="time" name="time">
    </div>

    <div>
        week: <input type="week" name="week">
    </div>

    <div>
        color: <input type="color" name="colour">
    </div>

    <div>
        email: <input type="email" name="email_address">
    </div>

    <div>
        month: <input type="month" name="month">
    </div>

    <div>
        range: <input type="range" name="range">
    </div>

    <div>
        hidden: <input type="hidden" name="invisible" value="1234">
    </div>

    <div>
        number: <input type="number" name="number">
    </div>

    <div>
        search: <input type="search" name="search">
    </div>

    <div>
        datetime-local: <input type="datetime-local" name="datetime">
    </div>

<!--- video 56 --->
	<div>
		textarea: <textarea name="content" rows="7" cols="50"></textarea>
	</div>

<!--- video 57 --->
	<div>
	<select name="country">
		<optgroup label="Europe">
			<option value="germany">Germany</option>
			<option value="france">France</option>
			<option value="uk" selected>United Kingdom</option>
		</optgroup>
		<optgroup label="America">
			<option value="brazil">Brazil</option>
			<option value="canada">Canada</option>
			<option value="usa">United States</option>
		</optgroup>
	</select>
	</div>


	<!--- video 57 --->
	<p>Which colours do you like?</p>

	<div>
		<input type="checkbox" name="colours[]" value="red"> Red
	</div>
	<div>
		<input type="checkbox" name="colours[]" value="green"> Green
	</div>
	<div>
		<input type="checkbox" name="colours[]" value="blue"> Blue
	</div>

	<!--- video 57 --->
	<div>
		<p>Which colour do you like?</p>

		<input type="radio" name="colour" value="blue" checked>Blue<br>
		<input type="radio" name="colour" value="red">Red<br>
		<input type="radio" name="colour" value="green">Green
	</div>

	<!--- video 57 --->
	<div>
		<label for="title">Title</label>: <input type="text" name="title" id="title">
	</div>

	<div>
		Content: <textarea name="content" rows="4" cols="40"></textarea>
	</div>

	<div>
		<label><input type="checkbox" name="visible" value="yes">Visible</label>
	</div>

	<div>
		<p>Colour:</p>
		<label><input type="radio" name="colour" value="blue" checked>Blue</label><br>
		<label><input type="radio" name="colour" value="red">Red</label><br>
		<label><input type="radio" name="colour" value="green">Green</label>
	</div>

	<!--- video 61--->
	<fieldset>
		<legend>Article</legend>
		<div>
			<label for="title">Title</label>:
			<input type="text" name="title" id="title" placeholder="Article title">
		</div>

		<div>
			<label for="content">Content</label>:
			<textarea name="content" rows="4" cols="40" id="content" placeholder="Content"></textarea>
		</div>
	</fieldset>

	<fieldset>
		<legend>Attributes</legend>
		<div>
			<label><input type="checkbox" name="visible" value="yes">Visible</label>
		</div>
	</fieldset>

	<fieldset>
		<legend>Colour</legend>
		<label><input type="radio" name="colour" value="blue" checked>Blue</label><br>
		<label><input type="radio" name="colour" value="red">Red</label><br>
		<label><input type="radio" name="colour" value="green">Green</label>
	</fieldset>

	<!--- video 62--->
	<fieldset>
		<legend>Article</legend>
		<div>
			<label for="title">Title</label>:
			<input type="text" name="title" id="title" value="Example" readonly>
		</div>

		<div>
			<label for="content">Content</label>:
			<textarea autofocus name="content" rows="4" cols="40" id="content" placeholder="Content"></textarea>
		</div>

		<div>
			<label for="lang">Language</label>:
			<select name="lang" id="lang" disabled>
				<option value="en">English</option>
				<option value="fr">French</option>
				<option value="es">Spanish</option>
			</select>
		</div>
	</fieldset>

	<fieldset>
		<legend>Colour</legend>
		<label><input type="radio" name="colour" value="blue" checked>Blue</label><br>
		<label><input type="radio" name="colour" value="red">Red</label><br>
		<label><input type="radio" name="colour" value="green">Green</label>
	</fieldset>

</form>
<button>Send</button>
<!--- video 63--->
<!--- zie form2.php --->


</body>
</html>
