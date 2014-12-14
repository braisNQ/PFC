<?php

    $clasificacion=array();

    $lista = $torneo->listaEquipos();
    if($lista->num_rows > 0)
    {
        while($row = $lista->fetch_assoc())
        {
            $partidos=$torneo->partidosEquipo($row['ID_equipo']);

            $equipo=array();
            $n=0;
            $v=0;
            $e=0;
            $d=0;

            while($p = $partidos->fetch_assoc())
            {
                if($row["ID_equipo"] == $p["ID_equipo1"])
                {
                    if($p["resultado_eq1"] > $p["resultado_eq2"])
                        $v++;
                    if($p["resultado_eq1"] == $p["resultado_eq2"])
                        $e++;
                    if($p["resultado_eq1"] < $p["resultado_eq2"])
                        $d++;
                }
                else
                {
                    if($p["resultado_eq1"] < $p["resultado_eq2"])
                        $v++;
                    if($p["resultado_eq1"] == $p["resultado_eq2"])
                        $e++;
                    if($p["resultado_eq1"] > $p["resultado_eq2"])
                        $d++;
                }
                $n++;                    
            }

            $puntos = $v*$torneo->getPuntosVictoria() + $e*$torneo->getPuntosEmpate() + $d*$torneo->getPuntosDerrota();
            $equipo[0]= $puntos;
            $equipo[1] = $row["nome"];
            $equipo[2] = $v;
            $equipo[3] = $e;
            $equipo[4] = $d;
            $equipo[5] = $n;
            $equipo[6] = $row["ID_equipo"];

            $clasificacion[]=$equipo;     
        }
    }

    echo "
        <table class='table table-striped table-hover'>
            <tr>
                <th>#</th>
                <th>Puntos</th>
                <th>Equipo</th>
                <th>V</th>
                <th>E</th>
                <th>D</th>
                <th>Xogados</th>
            </tr>
    ";

    //ordenar o array por puntos
    usort($clasificacion, function($a, $b) {
        return $b[0] - $a[0];
    });

    for ($i=0; $i<count($clasificacion);$i++)
    {
        echo "<tr>";
            echo "<td>".($i +1)."</td>";
            echo "<td>".$clasificacion[$i][0]."</td>";
            echo "<td><a href='equipo.php?id=".$clasificacion[$i][6]."'>".$clasificacion[$i][1]."</a></td>";
            echo "<td>".$clasificacion[$i][2]."</td>";
            echo "<td>".$clasificacion[$i][3]."</td>";
            echo "<td>".$clasificacion[$i][4]."</td>";
            echo "<td>".$clasificacion[$i][5]."</td>";
        echo "</tr>";
    }

    echo "</table>";
?>