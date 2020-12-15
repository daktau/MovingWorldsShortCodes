<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortCode;

class ApiController extends Controller
{
	public function getAllShortcodesForUser() 
	{
      	// logic to get all shortcodes...

      	return response()->json(["message" => "getAllShortcodes called!"], 201);
    }

    public function createShortcode(Request $request) 
    {
      	// logic to create a Shortcode record...


      	//check the validity of the shortcode if supplied...
      	if(!is_null($request->shortcode))
      	{
      		$return = $this->checkShortcodeString($request->shortcode, "Create");		
      	}
      	else
      	{
      		//create one as nothing was supplied
      		$i = 0;      		
      		while($i==0)
      		{
      			//Create a new code and then test it...
      			$request->shortcode = $this->generateShortcode();
      			$return = $this->checkShortcodeString($request->shortcode, "Create");
      			
      			if($return=== true)
      			{
      				$i++;      				
      			}
      		}
      	}

		//check that the return is valid
		if ($return===true) {
			//insert shortcode into the database....
			$shortcode = new ShortCode;
			$shortcode->shortcode = $request->shortcode;
			$shortcode->url = $request->url;
			$shortcode->user_id = $request->user_id;
			$shortcode->save();
			return response()->json(["message" => "Success!"], 201);
		}
		else
		{
			return response()->json(["message" => $return], 404);			
		}
    }

    public function getShortcode($id) 
    {
      	// logic to get a Shortcode record...
      	if (ShortCode::where('id', $id)->exists()) {
	        $shortcode = ShortCode::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
	        return response($shortcode, 200);
	    } 
	    else 
	    {
	        return response()->json(["message" => "ShortCode Not found"], 404);
	    }
    }

    public function updateShortcode(Request $request, $id) 
    {
      	// logic to update a Shortcode record...
      	
		//check the validity of the shortcode...
      	$return = $this->checkShortcodeString($request->shortcode, "Update");	

      	if($return === true)
      	{	      
	    	$errString = "";

	    	if(is_null($request->url) || strlen($request->url)<4)
	    	{
	    		$errString = "No URL supplied";
	    		return response()->json(["message" => $errString], 404);
	    	}

	      	if (ShortCode::where('id', $request->id)->exists()) 
	      	{
		        $shortcode = ShortCode::find($request->id);
		        $shortcode->shortcode = $request->shortcode;
		        $shortcode->url = $request->url;
		        $shortcode->user_id = $request->user_id;
		        $shortcode->save();

		        return response()->json(["message" => "Shortcode updated successfully"], 200);
		    } 
	        else 
	        {
	        	return response()->json(["message" => "Shortcode not found"], 404);	        
	    	}
	    }
	    else
	    {
	    	//shortcode not valid so return the error message
	    	return response()->json(["message" => $return], 404);			
	    }
    }

    public function deleteShortcode ($id) 
    {
      	// logic to delete a Shortcode record...
      	if(ShortCode::where('id', $id)->exists()) {
	        $shortcode = ShortCode::find($id);
	        $shortcode->delete();

	        return response()->json([
	          "message" => "Shortcode deleted"
	        ], 202);
	      } else {
	        return response()->json([
	          "message" => "Shortcode not found"
	        ], 404);
	      }
    }

    private function generateShortcode($strLength = 6)
    {
	    // String of all alphanumeric character 
	    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
	  
	    return substr(str_shuffle($str_result), 0, $strLength); 
    }

    private function checkShortcodeString ($shortcode, $CreateOrUpdate) 
    {
    	// logic to check a Shortcode string...
    	
    	//check that the string is not already taken buy checking the database
    	if ($CreateOrUpdate == "Create" && ShortCode::where('shortcode', $shortcode)->exists()) 
    	{	        
	        return "This shortCode is already taken.";
	    } 


    	$shortcodeLength = strlen($shortcode);
    	$errString = "";

    	if($shortcodeLength<4)
    	{
    		$errString .= "Shortcut needs to have at least 4 characters.";
    	}

    	//remove any non alphanumeric chars...
    	$shortcode = preg_replace( '/[\W]/', '', $shortcode);

    	//check to see what the error msg should be
    	if($shortcodeLength > strlen($shortcode))
    	{    	
    		if(strlen($errString)>0)
    		{	    		
    			$errString = substr($errString, 0, strlen($errString)-1) . " and can only contain numbers and letters.";   		
    		}
    		else
    		{
    			$errString .= "The shortcode can only contain numbers and letters.";   		
    		}
    	}

    	if(strlen($errString)>0)
    	{
    		return $errString;    		
    	}
    	else
    	{
    		return true;
    	}
    }
}
