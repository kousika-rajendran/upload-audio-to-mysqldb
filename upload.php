<?php 
if(isset($_POST['save_audio']) && $_POST['save_audio']=="Upload Audio")
{
   $dir='uploads/';
   $audio_path=$dir.basename($_FILES['audioFile']['name']);
   if(move_uploaded_file($_FILES['audioFile']['tmp_name'],$audio_path))
   {
       echo 'uploaded successfully.';
       saveAudio($audio_path);
       displayAudios();
   }
}
function saveAudio($fileName)                                            //function save audio is used for saving the uploaded audio file to mysqldb
{
    $conn=mysqli_connect('localhost','root','kousika740','threeway');    //connecting to mysqldb
    if(!$conn)
    {
         die('server not connected');                                    // this command will be executed if mysqldb is not successfully connected
    }
    $query="insert into audios(filename)values('{$fileName}')";          // here the uploaded audio file's name is inseted into the database.
    mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0)
    {
       echo "audio file path saved in database.";                       // this command is executed after successfully saving the audio file path
       echo "<br/><br/>";
     }
    mysqli_close($conn);                                               // connection to the mysqldb is closed
 
}
function displayAudios()                                               // display audio fuction is used to display all the audio file that has be saved in the datbase.
{
    $conn=mysqli_connect('localhost','root','kousika740','threeway');
    if(!$conn)
    {
          die('server not connected');
     }
     $query = "select * from audios";                                  //retrieves the saves audio path from the mysqldb
     $r=mysqli_query($conn,$query);
     while($row=mysqli_fetch_array($r))                               
     {
          echo '<a href="play.php?name='.$row['filename'].'">'.$row['filename'].'</a>';             //retrival of data by each row
          echo "<br/>";
     }
     mysqli_close($conn);                                               // connection to the mysqldb is closed
}
?>
