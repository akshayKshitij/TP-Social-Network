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
				<ul>
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
 </div>
