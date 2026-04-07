<?php

 $science=0;
 $magnetometer=0;
 $Gamma_Ray_and_Neutron_Spectrometer=0;
 $low_gain_antenna=0;
 $multispectral=0;
 $navigation=0;
 $cold_gas_thrusters=0;
 $star_trackers=0;
 $sun_sensors=0;
 $sp_thruster=0;
 $video=0;
 $communication=0;
 $xband=0;
 $dsoc=0;
 $spacecraft=0;
 $central_core=0;
 $dimensions=0;
 $fun_facts=0;
 $materials=0;
 $threeDimensional_model=0;
 $astroid=0;
 $spacecraft_model=0;

    
$link=mysqli_connect("localhost","root","root","statistical_output");

if ($link){
    echo "connect MySQL successfully!";
}
else if (mysqli_connect_errno($link)) 
{ 
    echo "connect MySQL fail! " . mysqli_connect_error(); 
} 
$file=fopen('./clickOnButton_log.csv','w');
$sql = "select * from data_save";
$download=$link->query($sql);
fwrite($file,"Button\t\t\t   Date\n");
    while($row=mysqli_fetch_array($download)){
        fwrite($file, $row['button'].",,,".$row['date']."\n");
    }
    fclose($file);

$file=fopen('./statistical_summary.csv','w');
fwrite($file,"Button Name,,,Clicks\n");


    $science_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Science' ORDER BY `button` DESC";
    $Science=$link->query($science_data);
        while(mysqli_fetch_array($Science)){
                $science+=1;
        }

    $magnetometer_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Magnetometer' ORDER BY `button` DESC";
    $Magnetometer=$link->query($magnetometer_data);
        while(mysqli_fetch_array($Magnetometer)){
                $magnetometer+=1;
          }

    $gamma_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Gamma Ray and Neutron Spectrometer' ORDER BY `button` DESC";
    $Gamma=$link->query($gamma_data);
        while(mysqli_fetch_array($Gamma)){
                $gamma+=1;
              }

    $low_gain_antenna_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Low Gain Antenna' ORDER BY `button` DESC";
    $Low_gain_antenna=$link->query($low_gain_antenna_data);
        while(mysqli_fetch_array($Low_gain_antenna)){
            $low_gain_antenna+=1;
            }

    $multispectral_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Multispectral' ORDER BY `button` DESC";
    $Multispectral=$link->query($multispectral_data);
        while(mysqli_fetch_array($Multispectral)){
            $multispectral+=1;
            }

    $navigation_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Navigation' ORDER BY `button` DESC";
    $Navigation=$link->query($navigation_data);
        while(mysqli_fetch_array($Navigation)){
            $navigation+=1;
            }

    $cold_gas_thrusters_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Cold Gas Thrusters' ORDER BY `button` DESC";
    $Cold_gas_thrusters=$link->query($cold_gas_thrusters_data);
        while(mysqli_fetch_array($Cold_gas_thrusters)){
            $cold_gas_thrusters+=1;
            }

    $star_trackers_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Star Trackers' ORDER BY `button` DESC";
    $Star_trackers=$link->query($star_trackers_data);
        while(mysqli_fetch_array($Star_trackers)){
            $star_trackers+=1;
            }

    $sun_sensors_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Sun Sensors' ORDER BY `button` DESC";
    $Sun_sensors=$link->query($sun_sensors_data);
        while(mysqli_fetch_array($Sun_sensors)){
            $sun_sensors+=1;
            }

    $sp_thruster_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'SP Thruster' ORDER BY `button` DESC";
    $Sp_thruster=$link->query($sp_thruster_data);
        while(mysqli_fetch_array($Sp_thruster)){
            $sp_thruster+=1;
            }
    
    $video_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Video' ORDER BY `button` DESC";
    $Video=$link->query($video_data);
        while(mysqli_fetch_array($Video)){
            $video+=1;
            }

    $communication_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Communication' ORDER BY `button` DESC";
    $Communication=$link->query($communication_data);
        while(mysqli_fetch_array($Communication)){
            $communication+=1;
            }
    
    $xband_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Xband' ORDER BY `button` DESC";
    $Xband=$link->query($xband_data);
        while(mysqli_fetch_array($Xband)){
            $xband+=1;
            }

    $dsoc_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Dsoc' ORDER BY `button` DESC";
    $Dsoc=$link->query($dsoc_data);
        while(mysqli_fetch_array($Dsoc)){
            $dsoc+=1;
            }
    
    $spacecraft_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Spacecraft' ORDER BY `button` DESC";
    $Spacecraft=$link->query($spacecraft_data);
        while(mysqli_fetch_array($Spacecraft)){
            $spacecraft+=1;
            }
    $central_core_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Central Core' ORDER BY `button` DESC";
    $Central_core=$link->query($central_core_data);
        while(mysqli_fetch_array($Central_core)){
            $central_core+=1;
            }

    $dimensions_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Dimensions' ORDER BY `button` DESC";
    $Dimensions=$link->query($dimensions_data);
        while(mysqli_fetch_array($Dimensions)){
            $dimensions+=1;
            }
    
    $fun_facts_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Fun Facts' ORDER BY `button` DESC";
    $Fun_facts=$link->query($fun_facts_data);
        while(mysqli_fetch_array($Fun_facts)){
            $fun_facts+=1;
            }
    
    $materials_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Materials' ORDER BY `button` DESC";
    $Materials=$link->query($materials_data);
        while(mysqli_fetch_array($Materials)){
            $materials+=1;
            }
    
    $threeDimensional_model_data = "SELECT * FROM `data_save` WHERE `button` LIKE '3D Model' ORDER BY `button` DESC";
    $ThreeDimensional_model=$link->query($threeDimensional_model_data);
        while(mysqli_fetch_array($ThreeDimensional_model)){
            $threeDimensional_model+=1;
            }
    
    $astroid_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Astroid' ORDER BY `button` DESC";
    $Astroid=$link->query($astroid_data);
        while(mysqli_fetch_array($Astroid)){
            $astroid+=1;
            }
    
            $spacecraft_model_data = "SELECT * FROM `data_save` WHERE `button` LIKE 'Spacecraft Model' ORDER BY `button` DESC";
            $Spacecraft_model=$link->query($spacecraft_model_data);
                while(mysqli_fetch_array($Spacecraft_model)){
                    $spacecraft_model+=1;
                    }
    
    



fwrite($file, "Science(Section),,,".$science."\n");
fwrite($file, "Magnetometer,,,".$magnetometer."\n");
fwrite($file, "'Gamma Ray and Neutron Spectrometer',,,".$gamma."\n");
fwrite($file, "Low Gain Antenna,,,".$low_gain_antenna."\n");
fwrite($file, "Multispectral,,,".$multispectral."\n");
fwrite($file, "Navigation(Section),,,".$navigation."\n");
fwrite($file, "Cold Gas Thrusters,,,".$cold_gas_thrusters."\n");
fwrite($file, "Star Trackers,,,".$star_trackers."\n");
fwrite($file, "Sun Sensors,,,".$sun_sensors."\n");
fwrite($file, "SP Thruster,,,".$sp_thruster."\n");
fwrite($file, "Video(Section),,,".$video."\n");
fwrite($file, "Communication(Section),,,".$communication."\n");
fwrite($file, "X-band,,,".$xband."\n");
fwrite($file, "DSOC,,,".$dsoc."\n");
fwrite($file, "Spacecraft(Section),,,".$spacecraft."\n");
fwrite($file, "Central Core,,,".$central_core."\n");
fwrite($file, "Dimensions,,,".$dimensions."\n");
fwrite($file, "Fun Facts,,,".$fun_facts."\n");
fwrite($file, "Materials,,,".$materials."\n");
fwrite($file, "3D Model(Section),,,".$threeDimensional_model."\n");
fwrite($file, "Astroid Model,,,".$astroid."\n");
fwrite($file, "Spacecraft Model,,,".$spacecraft_model."\n");




fclose($file);
$link->close();

?>