<?php
	
	// Just return the output (object) formated as JSON
        header('Content-Type: application/json');
        print(json_encode($output));