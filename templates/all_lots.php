  <main>
      <div class="container">
          <section class="lots">
              <h2>Все лоты в категории <span><?= $category['name']; ?></span></h2>
              <ul class="lots__list">
                  <?php foreach ($lots as $lot) : ?>
                      <li class="lots__item lot">
                          <div class="lot__image">
                              <img src="<?= htmlspecialchars($lot['image']); ?>" width="350" height="260" alt="<?= htmlspecialchars($lot['title']); ?>">
                          </div>
                          <div class="lot__info">
                              <span class="lot__category" <?= htmlspecialchars($lot['name']); ?>></span>
                              <h3 class="lot__title"><a class="text-link" href="lot.php?lot_id=<?= $lot['id']; ?>"><?= htmlspecialchars($lot['title']); ?></a></h3>
                              <div class="lot__state">
                                  <div class="lot__rate">
                                      <span class="lot__amount">Стартовая цена</span>
                                      <span class="lot__cost"><?= formate_cost($lot['cost']); ?></span>
                                  </div>
                                  <?php $res = get_dt_range($lot['dt_end']); ?>
                                  <div class="lot__timer timer <?= ($res < 1) ? 'timer--finishing' : ''; ?>">
                                  </div>
                              </div>
                          </div>
                      </li>
                  <?php endforeach; ?>
              </ul>
          </section>
          <?php if ($pages_count > 1) : ?>
              <ul class="pagination-list">
                  <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
                  <?php foreach ($pages as $page) : ?>
                      <li class="pagination-item <?php if ($page === $cur_page) : ?>pagination__item--active<?php endif; ?>">
                          <a href="/?page=<?= $page; ?>"><?= $page; ?></a>
                      </li>
                  <?php endforeach; ?>
                  <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
              </ul>
          <?php endif; ?>
      </div>
  </main>
