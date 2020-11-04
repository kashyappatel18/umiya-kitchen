<h4><?= $title ?></h4>
<div class="row">
     <div class="col-lg-3">
        <div class="card text-center">
          <div class="card-block">
              <h4 class="card-title text-danger"><?= number_format($bills_receivable,2); ?></h4>
              <p class="card-subtitle mb-2 text-muted">Bills Receivable</p>
          </div>
        </div>
     </div>
    <div class="col-lg-3">
        <div class="card text-center">
          <div class="card-block">
              <h4 class="card-title text-primary"><?= number_format($bank_bal,2); ?></h4>
              <p class="card-subtitle mb-2 text-muted">HDFC Bank Ltd.</p>
          </div>
        </div>
     </div>
    <div class="col-lg-3">
        <div class="card text-center">
          <div class="card-block">
              <h4 class="card-title text-primary"><?= number_format($cash_on_hand,2); ?></h4>
              <p class="card-subtitle mb-2 text-muted">Cash on Hand</p>
          </div>
        </div>
     </div>
</div>
<p class="text-primary align-center">Welcome to Cloud8in Technologies Private Limited.</p>