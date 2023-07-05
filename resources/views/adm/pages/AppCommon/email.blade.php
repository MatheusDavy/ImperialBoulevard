@if(!isset($textmode) || !$textmode)
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body{
            font-family: Arial;
            font-size: 0;
            font-size: 15px;
            color: #000;
        }
        body table, body table *{
            border: 0;
        }
        .my-body a{
            color: #000;
            text-decoration: underline;
        }
        .my-body p{
            margin: 0;
        }
    </style>
</head>
<body style="margin: 0; padding: 0;" class="my-body">
    <table style="margin: 0 auto; width: 600px; background: #ddd; border-radius: 4px; padding: 20px;">
        <thead>
            <tr>
                <th style="padding: 25px; text-align: center;">
                    <a href="{{ url('') }}"><img src="cid:logo-email.png" style="max-width: 240px;max-height: 120px;"/></a>
                </th>
            </tr>
        </thead>
        <tbody style="background: #fff; display: block; border-radius: 4px; padding: 0 15px;">
            <tr><td><br></td></tr>
            @if(is_array($body))
                @foreach ($body as $key => $val)
                    <tr><td><strong><?php echo is_numeric($key) ? '' : $key; ?></strong> <?php echo $val; ?></td></tr>
                    <tr><td><br></td></tr>
                @endforeach
            @else
                <tr><td><?php echo $body; ?></td></tr>
                <tr><td><br></td></tr>
            @endif
        </tbody>
    </table>
</body>
</html>
@else
    @php
        $ret = '';
    @endphp
    @if(is_array($body))
        @foreach ($body as $key => $val)
            <?php $ret .=  is_numeric($key) ? $val."\n" : $key.': '.$val."\n"; ?>
        @endforeach
    @else
        <?php $ret = $body; ?>
    @endif
<?php echo $ret; ?>
@endif