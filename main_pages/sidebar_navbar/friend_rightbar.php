<div>
				<h4> DETAILS</h4>					 
				<ul >
				<li>Name : <?php echo $wallUser->name ?></li>
				<li>Email: <?php echo $wallUser->email ?></li>
				<li>Age: <?php echo $wallUser->age ?></li>
				<li>Country: <?php echo $wallUser->country ?></li>
				<li>DOB: <?php echo $wallUser->dob ?></li>
				</ul>	
				
				<br>
				<h4> INTERESTS</h4>
				<ul>
				<?php				 
				$interests=$wallUser->getInterests();
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
 </div>
