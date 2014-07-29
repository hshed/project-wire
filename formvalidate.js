<script type="text/javascript">
function validateForename(field) {
                if (field == "") return "No First Name was entered.\\n"
				return ""
				                 }

function validateUsername(field)  {
                if (field == "") return "No Username was entered.\\n"
   				return ""
				                  }

function validatePassword(field)  {
                if (field == "") return "No Password was entered.\\n"
                else if (field.length < 6) return "Password must be at least 6 characters. \\n"
				return ""
                                  }

function validateEmail(field)     {
                if (field == "") return "No Email was entered.\\n"
                else if (!((field.indexOf(".") >0) &&
                            (field.indexOf("@") >0) ||
                            /[^a-zA-Z0-9.@_-]/.test(field))	
                    return "The Email address is invalid. \\n"
                return""				
				                  }

</script>								  