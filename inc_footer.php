<footer>
    <!-- Footer Content -->
    <p class='footer-intro'>&copy;
        <?php echo date("Y"); ?> Spydy. All rights reserved.
    <p class='footer-intro'>Phone: +60 10-520 2492 | Email: wooijunanimator@gmail.com</p>
    <p>Text Size:</br>
        <a class='font-plus' href="?font=plus">+</a>
        <a class='font-minus' href="?font=minus">-</a>
        <a class='font-reset' href="?font=reset">Reset</a>
    </p>
    <a href="javascript:void(0);" onclick='printcontent("printcontent")'>Print Content</a>
        <a href="javascript:void(0);" onclick='window.print()'>Print Page</a>
</footer>

<script type="text/javascript">
    //script for printing the page contents.
    function printcontent(areaID) {
        var printContent = document.getElementById(areaID);
        var WinPrint = window.open('', '', 'width=900,height=650');
        WinPrint.document.write(printContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    }
</script>