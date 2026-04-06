<?php
require 'includes/db.php';
$rows=$pdo->query("SELECT s.schedule_id,t.train_number,t.train_name,s.fare_1st_class,s.fare_2nd_class,s.fare_3rd_class FROM schedules s JOIN trains t ON s.train_id=t.train_id WHERE t.status='Active' ORDER BY s.schedule_id ASC LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $r){echo implode(' | ',[$r['schedule_id'],$r['train_number'],$r['train_name'],(string)$r['fare_1st_class'],(string)$r['fare_2nd_class'],(string)$r['fare_3rd_class']])."\n";}
?>
