<div >
				<h4> DETAILS</h4>					 
				<ul >
				<li>Name : <?php echo $user->name ?></li>
				<li>Email: <?php echo $user->email ?></li>
				<li>Age: <?php echo $user->age ?></li>
				<li>Country: <?php echo $user->country ?></li>
				<li>DOB: <?php echo $user->dob ?></li>
				</ul>	
				
				<br>
				<h4> INTERESTS</h4>
				<ul id="myInterests">
				<?php				 
				$interests=$user->getInterests();
				$size=count($interests);
				for ($i=0;$i<$size;$i++)
				{
					$temp=$interests[$i];
					echo "<li>";
					echo $temp['interest_text'];
					echo "</li>";	
				}	
				?>
				</ul>
				<select name="interests" id="interests" style="margin-bottom:10px;width:200px" >
				<option value="">Select Interest</option>
				<option value="Cricket">Cricket</option>
				<option value="Football">Football</option>
				<option value="Badminton">Badminton</option>
				<option value="Chess">Chess</option>
				<option value="Singing">Singing</option>
				<option value="Dancing">Dancing</option>
				<option value="Programming">Programming</option>
				<option value="Watching Movies">Watching Movies</option>
				<option value="Reading Comics">Reading Comics</option>		
				</select>
				<br>

				<?php echo '<button class="btn btn-sm btn-success" onclick="addInterest('.$user->userId.')">Add Interest</button>'; ?>
 </div>
 
<script>
$(document).ready(function() {
  $("#interests").select2();
});
function addInterest(userId)
{
	var e = document.getElementById("interests");
	var interestText= e.options[e.selectedIndex].value;
	
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
			var newInterest= "<li>"+ interestText + "</li>";
								
        	$("#myInterests").append(newInterest);
			$.toaster({ priority : 'info', title : 'TP', message : "The Interest has been added."});			
        }
    }
    xmlhttp.open("GET", "../ajax/addInterest.php?userId=" + userId.toString() + "&interestText=" + interestText, true);
    xmlhttp.send();
}
</script>
