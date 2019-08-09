<?php
get_header();
global $ss_theme_option;

$user = ss_get_user();
$found_coupons = array();

$search = filter_input(INPUT_GET, 'search');

if ($search) {
$found_coupons = ss_get_seller_coupons($search);
}

?>

<div class="dashboard page">

	<div class="container">

		<h1 class="dashboard__title"><?= __('Seller Dashboard') ?></h1>

		<div class="row filter__section">

			<div class="col-md-2">
				<div class="orders__sidebar">
					<div class="orders__sidebar__photo">
						<?= wp_get_attachment_image(get_field('photo', 'user_' . $user->ID)) ?>
					</div>
					<h5 class="orders__sidebar__title"><?= __("Hello, $user->display_name") ?></h5>
					<a href="<?= wp_logout_url(SS_LOGIN_PAGE) ?>">
						<button class="button button-1"><?= __('logout') ?></button>
					</a>
					<ul>
						<li><a href="#coupons" class="link link_grey active filter__button" data-filter="list"><?= __('Coupons List') ?></a></li>
						<li><a href="#reports" class="link link_grey filter__button" data-filter="reports"><?= __('Reports') ?></a></li>
					</ul>
				</div>
			</div>

			<div class="col-md-10">
				<div class="dashboard__main filter__item list">
					<h2 class="dashboard__main__title"><?= __('Find the right coupon') ?></h2>
					<div class="dashboard__main__subtitle"><?= __('You can search by order number, customer name, or customer phone') ?></div>

					<form class="search" method="GET">
						<input type="text" placeholder="<?= __('Search') ?>" class="input" name="search" value="<?= $search ?? '' ?>">
						<button class="button button-3" type="submit"><img src="<?= ss_asset('img/icons/search.svg') ?>" alt="search"></button>
					</form>

					<?php if (empty($found_coupons)) : ?>
						<div class="dashboard__search-not-found"><?= __('Coupon not found') ?></div>
					<?php else : ?>
						<div class="dashboard__search-result">
							<h2 class="result__title"><?= __('Relevant results') ?></h2>
							<?php foreach ($found_coupons as $order_id => $coupon_data) : ?>
								<?php
								$order_item_product = new WC_Order_Item_Product($coupon_data->order_item_id);
								$product = $order_item_product->get_product();
								$order = wc_get_order($order_id);
								?>

								<div class="order">
									<div class="order__photo"><?= $product->get_image() ?></div>
									<div class="order__content">
										<a href="<?= get_permalink($product->id) ?>" class="order__title"><?= $product->get_name() ?></a>
										<div class="order__subtitle_mute"><?= $product->get_short_description() ?></div>

										<div class="order__details">
											<div class="order__details__block">
												<div class="order__block__title"><?= __('order no') ?>: </div>
												<div class="order__block__text">#<?= $order_id ?></div>
											</div>
											<div class="order__details__block">
												<div class="order__block__title"><?= __('Coupon Code') ?>: </div>
												<div class="order__block__text"><?= $coupon_data->coupon_number ?></div>
											</div>
											<div class="order__details__block">
												<div class="order__block__title"><?= __('Purchase Date') ?>: </div>
												<div class="order__block__text"><?= $order->get_date_created()->date_i18n('F j, Y') ?></div>
											</div>
											<div class="order__details__block">
												<?php
												$coupon_validity = get_field('coupon_validity', $product->id);
												$coupon_validity = !empty($coupon_validity) && $coupon_validity > 0 ? $coupon_validity : $ss_theme_option['coupon-validity'];
												$order_date = clone ($order->get_date_completed() ?? $order->get_date_created());
												$expiration_date = $order_date->add(new DateInterval('P' . $coupon_validity . 'D'));
												?>
												<div class="order__block__title"><?= __('Expiration Date') ?>: </div>
												<div class="order__block__text"><?= $expiration_date->date_i18n('F j, Y') ?></div>
											</div>
										</div>

										<div class="order__client">
											<h5 class="order__client__title"><?= __('Client details') ?></h5>
											<div class="order__client__info">
												<div class="order__client__info__item"><?= __('Name') ?>: <?= $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() ?></div>
												<div class="order__client__info__item"><?= __('Phone') ?>: <?= $order->get_billing_phone() ?></div>
												<div class="order__client__info__item"><?= __('Email') ?>: <?= $order->get_billing_email() ?></div>
											</div>
										</div>

										<div class="order__price"><?= $order_item_product->get_total() ?><?= get_woocommerce_currency_symbol() ?></div>
										<button class="button button-1 button-1_140 button-redeem" data-order="<?= $order_id ?>" data-item="<?= $coupon_data->order_item_id ?>">redeem coupon</button>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="filter__item reports">
					<div class="dashboard__block">
						<div class="dashboard__filter">
							<a href="#!" class="button button-1 button_light">Last 7 days</a>
							<a href="#!" class="button button-1">Last 30 days</a>
							<div class="calendar_wrap">
								<!-- <a href="#!" class="button button-1 button_light calendar-button">14.05.2019 - 25.08.2019</a>
									<div class="calendar">
										<div class="calendar__month">
											<a href="#!" class="calendar__arrow"><img src="img/icons/angle-left.svg" alt=""></a>
											<div class="calendar__month__title">May 2019</div>
											<a href="#!" class="calendar__arrow"><img src="img/icons/angle-right.svg" alt=""></a>
										</div>
										<table>
											<tr>
												<th><div class="calendar__day__title">Su</div></th>
												<th><div class="calendar__day__title">Mo</div></th>
												<th><div class="calendar__day__title">Tu</div></th>
												<th><div class="calendar__day__title">We</div></th>
												<th><div class="calendar__day__title">Th</div></th>
												<th><div class="calendar__day__title">Fr</div></th>
												<th><div class="calendar__day__title">Sa</div></th>
											</tr>
											<tr>
												<td><div class="calendar__day mute">30</div></td>
												<td><div class="calendar__day">1</div></td>
												<td><div class="calendar__day">2</div></td>
												<td><div class="calendar__day">3</div></td>
												<td><div class="calendar__day">4</div></td>
												<td><div class="calendar__day active">5</div></td>
												<td><div class="calendar__day interval">6</div></td>
											</tr>
											<tr>
												<td><div class="calendar__day interval">7</div></td>
												<td><div class="calendar__day interval">8</div></td>
												<td><div class="calendar__day active">9</div></td>
												<td><div class="calendar__day">10</div></td>
												<td><div class="calendar__day">11</div></td>
												<td><div class="calendar__day">12</div></td>
												<td><div class="calendar__day">13</div></td>
											</tr>
											<tr>
												<td><div class="calendar__day">14</div></td>
												<td><div class="calendar__day">15</div></td>
												<td><div class="calendar__day">16</div></td>
												<td><div class="calendar__day">17</div></td>
												<td><div class="calendar__day">18</div></td>
												<td><div class="calendar__day">19</div></td>
												<td><div class="calendar__day">20</div></td>
											</tr>
											<tr>
												<td><div class="calendar__day">21</div></td>
												<td><div class="calendar__day">22</div></td>
												<td><div class="calendar__day">23</div></td>
												<td><div class="calendar__day">24</div></td>
												<td><div class="calendar__day">25</div></td>
												<td><div class="calendar__day">26</div></td>
												<td><div class="calendar__day">27</div></td>
											</tr>
											<tr>
												<td><div class="calendar__day">28</div></td>
												<td><div class="calendar__day">29</div></td>
												<td><div class="calendar__day">30</div></td>
												<td><div class="calendar__day">31</div></td>
												<td><div class="calendar__day mute">1</div></td>
												<td><div class="calendar__day mute">2</div></td>
												<td><div class="calendar__day mute">3</div></td>
											</tr>
										</table>
									</div> -->
								<input type='text' class="datepicker-here button button-1" data-range="true" data-multiple-dates-separator=" - " placeholder="Custom" data-language='en' />
							</div>
						</div>
						<div class="dashboard__numbers">

							<div class="dashboard__number">
								<div class="dashboard__number__title">Transactions</div>
								<div class="dashboard__number__text">67</div>
							</div>
							<div class="dashboard__number">
								<div class="dashboard__number__title">Revenue</div>
								<div class="dashboard__number__text">5.031.40</div>
							</div>

						</div>
					</div>

					<div class="dashboard__vouchers">
						<h2 class="dashboard__vouchers__title">My Vouchers</h2>

						<table class="dashboard__vouchers__table">
							<tr>
								<th>
									<div class="vouchers__title">voucher name
										<div class="vouchers__title__angles">
											<a href="#!" class="voucher__angle voucher__angle_top active"></a>
											<a href="#!" class="voucher__angle voucher__angle_bottom"></a>
										</div>
									</div>
								</th>
								<th>
									<div class="vouchers__title">category
										<div class="vouchers__title__angles">
											<a href="#!" class="voucher__angle voucher__angle_top"></a>
											<a href="#!" class="voucher__angle voucher__angle_bottom"></a>
										</div>
									</div>
								</th>
								<th>
									<div class="vouchers__title">Transactions
										<div class="vouchers__title__angles">
											<a href="#!" class="voucher__angle voucher__angle_top"></a>
											<a href="#!" class="voucher__angle voucher__angle_bottom"></a>
										</div>
									</div>
								</th>
								<th>
									<div class="vouchers__title">Total Revenue
										<div class="vouchers__title__angles">
											<a href="#!" class="voucher__angle voucher__angle_top"></a>
											<a href="#!" class="voucher__angle voucher__angle_bottom"></a>
										</div>
									</div>
								</th>
							</tr>
							<tr>
								<td>
									<div class="vouchers__text">Product Title Goes Here and here and here and here and here and here and here Product Title Product Title Goes </div>
								</td>
								<td>
									<div class="vouchers__text">Name category</div>
								</td>
								<td>
									<div class="vouchers__text">25</div>
								</td>
								<td>
									<div class="vouchers__text">25 456 135</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="vouchers__text">Product Title Goes Here and here and here and here and here and here and</div>
								</td>
								<td>
									<div class="vouchers__text">Name category</div>
								</td>
								<td>
									<div class="vouchers__text">25</div>
								</td>
								<td>
									<div class="vouchers__text">25 456 135</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="vouchers__text">Product Title Goes Here and here </div>
								</td>
								<td>
									<div class="vouchers__text">Name category</div>
								</td>
								<td>
									<div class="vouchers__text">25</div>
								</td>
								<td>
									<div class="vouchers__text">25 456 135</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="vouchers__text">Product Title Goes Here and here and here and here and here and here and here Product Title</div>
								</td>
								<td>
									<div class="vouchers__text">Name category</div>
								</td>
								<td>
									<div class="vouchers__text">25</div>
								</td>
								<td>
									<div class="vouchers__text">25 456 135</div>
								</td>
							</tr>

						</table>

						<div class="dashboard__vouchers__table__mobile">
							<div class="table-item">
								<div class="row">
									<div class="col-6">
										<div class="table-title">voucher name</div>
									</div>
									<div class="col-6">
										<div class="table-value">Product Title Goes Here and here and here and here and here and here</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="table-title">category</div>
									</div>
									<div class="col-6">
										<div class="table-value">Name category</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="table-title">Transactions</div>
									</div>
									<div class="col-6">
										<div class="table-value">25</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="table-title">Total Revenue</div>
									</div>
									<div class="col-6">
										<div class="table-value">25 456 135</div>
									</div>
								</div>
							</div>

							<div class="table-item">
								<div class="row">
									<div class="col-6">
										<div class="table-title">voucher name</div>
									</div>
									<div class="col-6">
										<div class="table-value">Product Title Goes Here and here and here and here and here and here</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="table-title">category</div>
									</div>
									<div class="col-6">
										<div class="table-value">Name category</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="table-title">Transactions</div>
									</div>
									<div class="col-6">
										<div class="table-value">25</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="table-title">Total Revenue</div>
									</div>
									<div class="col-6">
										<div class="table-value">25 456 135</div>
									</div>
								</div>
							</div>

							<div class="table-item">
								<div class="row">
									<div class="col-6">
										<div class="table-title">voucher name</div>
									</div>
									<div class="col-6">
										<div class="table-value">Product Title Goes Here and here and here and here and here and here</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="table-title">category</div>
									</div>
									<div class="col-6">
										<div class="table-value">Name category</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="table-title">Transactions</div>
									</div>
									<div class="col-6">
										<div class="table-value">25</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="table-title">Total Revenue</div>
									</div>
									<div class="col-6">
										<div class="table-value">25 456 135</div>
									</div>
								</div>
							</div>

						</div>

						<ul class="pagination">
							<li class="pagination__item"><a href="#!" class="pagination__link">1</a></li>
							<li class="pagination__item"><a href="#!" class="pagination__link active">2</a></li>
							<li class="pagination__item"><a href="#!" class="pagination__link">3</a></li>
							<li class="pagination__item"><a href="#!" class="pagination__link">4</a></li>
						</ul>
					</div>
				</div>
			</div>

		</div>

	</div>

</div>

<?php get_footer(); ?>