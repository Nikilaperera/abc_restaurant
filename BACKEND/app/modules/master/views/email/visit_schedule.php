<html>
<body>
<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:16px;line-height:107%;">Dear All,</span></p>
<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:16px;line-height:107%;">Please find the visit schedule details below.</span></p>

<table style="border-collapse: collapse; width: 100%;">
    <thead>
    <tr style="background-color: #BDD6EE;">
        <th style="border: 1px solid black; ">
            Application No
        </th>
        <th style="border: 1px solid black; ">
            Location
        </th>
        <th style="border: 1px solid black; ">
            Date
        </th>
        <th style="border: 1px solid black; ">
            Time
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($visit_Details as $row): ?>
        <tr>
            <td style="border: 1px solid black; "><?php echo $row->application_no; ?></td>
            <td style="border: 1px solid black; "><?php echo $row->location; ?></td>
            <td style="border: 1px solid black; "><?php echo $row->date; ?></td>
            <td style="border: 1px solid black; "><?php echo $row->time; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:16px;line-height:107%;">&nbsp;</span></p>
<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:16px;line-height:107%;">Thanks &amp; regards,</span></p>
<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:16px;line-height:107%;">abc_restaurant Admin</span></p>
<p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:16px;line-height:107%;">Institute Of Bankers of Sri Lanka</span></p>
</body>
</html>
