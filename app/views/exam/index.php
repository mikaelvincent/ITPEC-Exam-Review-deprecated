<?php
$title = htmlspecialchars($exam_name) . " | ITPEC Exam Review"; ?>

<div class="row gy-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5 mb-5">
					<div class="col">
						<a class="btn btn-secondary btn-lg h-100 w-100" role="button" href="#">2008 April - AM</a>
					</div>
					<div class="col">
						<a class="btn btn-success btn-lg h-100 w-100" role="button" href="#">2007 October - AM</a>
					</div>
					<div class="col">
						<a class="btn btn-secondary btn-lg disabled h-100 w-100" role="button" href="#">2007 April - AM</a>
					</div>
				</div>
				<div class="row row-cols-1 mb-5">
					<div class="col">
						<button class="btn btn-outline-warning btn-lg w-100" type="button" data-bs-target="#reset-progress-confirm" data-bs-toggle="modal">Reset Progress for FE Exam</button>
						<div class="modal fade" role="dialog" tabindex="-1" id="reset-progress-confirm">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title fw-bold">Confirm Progress Reset</h4>
										<button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
									</div>
									<div class="modal-body">
										<p>Are you sure you want to reset your progress for FE Exam?</p>
										<p>This action is irreversible and cannot be undone.</p>
									</div>
									<div class="modal-footer">
										<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
										<button class="btn btn-danger" type="button">Reset All Progress</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
