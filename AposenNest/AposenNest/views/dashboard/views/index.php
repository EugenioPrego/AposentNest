<div class="container-main-card">
    <div class="cards card1">
        <div>
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </div>
        <div class="txt">
            <p>RENDA ATUAL</p>
            <strong><?php echo 'KZ ' . number_format($totalRenda, 3, ',', '.'); ?></strong>
        </div>
    </div>

    <div class="cards card2">
        <div>
            <i class="fa-solid fa-sack-dollar"></i>
        </div>
        <div class="txt">
            <p>Investimentos</p>
            <strong><?php echo 'KZ ' . number_format($totalInvestimentos, 3, ',', '.'); ?></strong>
        </div>
    </div>

    <div class="cards card3">
        <div>
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div class="txt">
            <p>DESPESAS</p>
            <strong><?php echo 'KZ ' . number_format($totalDespesas, 3, ',', '.'); ?></strong>
        </div>
    </div>
</div>

<div class="container-main-chartjs">
    <div class="container-main-chartjs1">
        <div id="columnchart_material" style="width: 500px; height: 250px;"></div>
    </div>

    <div class="container-main-chartjs2">
        <div id="piechart" style="width: 300px; height: 250px;"></div>
    </div>
</div>