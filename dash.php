<?php
session_start();
error_reporting(0);
$varsesion = $_SESSION['auth'];
if (isset($varsesion)) {

    function api_get($url, $request = array(), $content = 'text/xml')
    {
        $curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: $content"));
        //curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo '<hr/>Curl error: ' . curl_error($ch) . '<hr/>';
        }
        curl_close($ch);
        return json_decode($response, true);
    }


    $currenciesAPI = array(
        'BTC' => array(
            'prices' => api_get('https://min-api.cryptocompare.com/data/price?fsym=BTC&tsyms=BTC,USD,MXN'),
        ),
        'ETH' => array(
            'prices' => api_get('https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=BTC,USD,MXN'),
        ),
        'XMG' => array(
            'prices' => api_get('https://min-api.cryptocompare.com/data/price?fsym=XMG&tsyms=BTC,USD,MXN'),
        ),
    );


    $balanceXMG = api_get('https://xmg.minerclaim.net/index.php?page=api&action=getuserbalance&api_key=207b16a23aaf472234574152b1c6911e65dc9483f68727554a973bc44e6bb4ee&id=3176');
    $workers = api_get('https://xmg.minerclaim.net/index.php?page=api&action=getuserworkers&api_key=207b16a23aaf472234574152b1c6911e65dc9483f68727554a973bc44e6bb4ee&id=3176');
    $hashrate = api_get('https://xmg.minerclaim.net/index.php?page=api&action=getuserhashrate&api_key=207b16a23aaf472234574152b1c6911e65dc9483f68727554a973bc44e6bb4ee&id=3176');

    $wallet = api_get('https://chainz.cryptoid.info/xmg/api.dws?q=getbalance&a=99Ck3o2W2L5L43Hsz4XXJNZLrJbLM7LyG1&key=1ab77aaf11bb');
    //echo $wallet;


    ?>
    <!doctype html>
    <html lang="en">

    <head>
        <title>Dashboard</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

        <link rel="shortcut icon" href="img/magi-green.png">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="css/estilo.css">


    </head>

    <body>
        <div>
            <nav class="navbar navbar-dark bg-dark">
                <a class="navbar-brand" href="#">
                    <img src="img/magi-green.png" width="30" height="30" class="d-inline-block align-top" alt="">
                    Dashboard
                </a>
                <a class="nav-link" href="chart.php">Chart</a>
                <a class="nav-link" href="data.php">Data</a>
            </nav>
        </div>

        <div class="container-fluid">
            <div class="row align-items-start justify-content-md-center">
                <div class="col col-lg-5">
                    <table class="table table-sm table-dark table-striped table-bordered table-hover">
                        <thead class="bg-info">
                            <tr class="">
                                <th class="text-center">Coin</th>
                                <th class="text-center">BTC</th>
                                <th class="text-center">USD</th>
                                <th class="text-center">MXN</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($currenciesAPI as $key => $value) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $key; ?></td>
                                    <td class="text-right"><?php echo sprintf('%.8f', $value['prices']['BTC']); ?></td>
                                    <td class="text-right"><?php echo sprintf('%.4f', $value['prices']['USD']); ?></td>
                                    <td class="text-right"><?php echo sprintf('%.4f', $value['prices']['MXN']); ?></td>
                                </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row align-items-start justify-content-md-center">
                <div class="col col-lg-5">
                    <table class="table table-sm table-dark table-striped table-bordered table-hover">
                        <thead class="bg-info">
                            <tr class="">
                                <th>Worker</th>
                                <th>Status</th>
                                <th>Hashrate</th>
                                <th>Difficulty</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php
                            //testing online:
                            //echo $workers['getuserworkers']['data'][2]['hashrate']=12.2;

                            foreach ($workers['getuserworkers']['data'] as $w) {
                                ?>
                                <tr <?php echo (($w['hashrate'] == 0) ? ' class="bg-secondary"' : ''); ?>>
                                    <td><?php echo $w['username']; ?></td>
                                    <td <?php echo (($w['hashrate'] == 0) ? ' class="bg-danger"' : ' class="bg-success"'); ?>><?php echo (($w['hashrate'] == 0) ? 'offline' : 'online'); ?></td>
                                    <td class="text-right"><?php echo $w['hashrate']; ?> <b>KH/s</b></td>
                                    <td class="text-right"><?php echo sprintf('%.8f', $w['difficulty']); ?></td>
                                </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <?php
            //guardar datos de hashrate to database
            require_once("includes/_db.php");

            date_default_timezone_set('America/Cancun');
            $fecha = date('Y-m-d H:i:s', time());

            $hash = $hashrate['getuserhashrate']['data'];

            $query = "INSERT INTO dash_data (data_hash, data_fecha) VALUES('$hash','$fecha')";
            mysqli_query($mysqli, $query);

            ?>


            <div class="row align-items-start justify-content-md-center">
                <div class="col col-lg-5">
                    <div class="alert alert-info" role="alert">
                        Total hashrate: <?php echo $hashrate['getuserhashrate']['data'], 4; ?> <b>KH/s</b>
                    </div>
                </div>
            </div>
            
            <!--WALLET DATA-->
            <div class="row align-items-start justify-content-md-center">
                <div class="col col-lg-5">
                    <div class="alert alert-primary" role="alert">
                        <h5>Wallet balance</h5>
                        <hr />
                        <div class="row">
                            <div class="col">

                                <?php echo sprintf('%.8f', $wallet); ?> <b>XMG</b>
                            </div>
                            <div class="col">
                                <div class="float-right">
                                    <?php echo round($wallet * $currenciesAPI['XMG']['prices']['USD'], 4); ?> <b>USD</b>
                                </div>
                                <div class="clearfix"></div>
                                <div class="float-right">
                                    <?php echo round($wallet * $currenciesAPI['XMG']['prices']['MXN'], 4); ?> <b>MXN</b>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-start justify-content-md-center">
                <div class="col col-lg-5">
                    <div class="alert alert-success" role="alert">
                        <h5>Confirmed balance</h5>
                        <hr />
                        <div class="row">
                            <div class="col">
                                <?php echo sprintf('%.8f', $balanceXMG['getuserbalance']['data']['confirmed']); ?> <b>XMG</b>
                            </div>
                            <div class="col">
                                <div class="float-right">
                                    <?php echo round($balanceXMG['getuserbalance']['data']['confirmed'] * $currenciesAPI['XMG']['prices']['USD'], 4); ?> <b>USD</b>
                                </div>
                                <div class="clearfix"></div>
                                <div class="float-right">
                                    <?php echo round($balanceXMG['getuserbalance']['data']['confirmed'] * $currenciesAPI['XMG']['prices']['MXN'], 4); ?> <b>MXN</b>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-start justify-content-md-center">
                <div class="col col-lg-5">
                    <div class="alert alert-warning" role="alert">
                        <h5>Unconfirmed balance</h5>
                        <hr />
                        <div class="row">
                            <div class="col">
                                <?php echo sprintf('%.8f', $balanceXMG['getuserbalance']['data']['unconfirmed']); ?> <b>XMG</b>
                            </div>
                            <div class="col">
                                <div class="float-right">
                                    <?php echo round($balanceXMG['getuserbalance']['data']['unconfirmed'] * $currenciesAPI['XMG']['prices']['USD'], 4); ?> <b>USD</b>
                                </div>
                                <div class="clearfix"></div>
                                <div class="float-right">
                                    <?php echo round($balanceXMG['getuserbalance']['data']['unconfirmed'] * $currenciesAPI['XMG']['prices']['MXN'], 4); ?> <b>MXN</b>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-start justify-content-md-center">
                <div class="col col-lg-5">
                    <div class="alert alert-danger" role="alert">
                        <h5>Orphaned balance</h5>
                        <hr />
                        <div class="row">
                            <div class="col">
                                <?php echo sprintf('%.8f', $balanceXMG['getuserbalance']['data']['orphaned']); ?> <b>XMG</b>
                            </div>
                            <div class="col">
                                <div class="float-right">
                                    <?php echo round($balanceXMG['getuserbalance']['data']['orphaned'] * $currenciesAPI['XMG']['prices']['USD'], 4); ?> <b>USD</b>
                                </div>
                                <div class="clearfix"></div>
                                <div class="float-right">
                                    <?php echo round($balanceXMG['getuserbalance']['data']['orphaned'] * $currenciesAPI['XMG']['prices']['MXN'], 4); ?> <b>MXN</b>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            setTimeout(function() {
                window.location.reload();
            }, 5 * 60 * 1000);
            document.write(new Date());
        </script>
    </body>

    </html>

<?php
} else {
    header("Location:index.html");
}
?>