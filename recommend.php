<?php
// The command to run your Streamlit app
$command = 'streamlit run ./main/App.py --server.port 8501 ';

// Run the command using shell_exec
$output = shell_exec($command);

// Print the output (this will show any error or success message from running the Streamlit command)
echo "<pre>$output</pre>";

// Redirect to the running Streamlit app (assuming it's on localhost:8501)
header("Location: http://localhost:8501");
exit();
?>
