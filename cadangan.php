<tbody class="text-center">
    <?php foreach ($users as $i => $item) : ?>
        <tr>
            <td><?= $i + 1; ?></td>
            <td><img src="<?= $item['image']; ?>" onerror="this.src='https://t4.ftcdn.net/jpg/00/64/67/63/360_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.jpg'" alt="" style="width: 50px; height: 50px; border-radius: 1000px;"></td>
            <td><?= $item['fullname']; ?></td>
            <td><?= $item['email']; ?></td>
            <td><?= $item['address']; ?></td>
            <td>
                <a href="" class="btn btn-sm btn-info"><i class="fe fe-edit"></i></a>
                <a href="" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

<?php foreach ($slider as $i => $item) : ?>
    <div class="col-12 col-md-4 mb-4">
        <div class="position-absolute p-1" style="right: 15px;">
            <button class="btn btn-sm btn-info"><i class="fe fe-edit"></i></button>
            <button class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></button>
        </div>
        <img src="<?= $item['image']; ?>" alt="" class="img-fluid rounded-lg" style="height: 120px; width: 100%;">
    </div>
<?php endforeach; ?>

<?php foreach ($category as $i => $item) : ?>
    <tr>
        <td><?= $i + 1; ?></td>
        <td><img src="<?= $item['image']; ?>" alt="" style="width: 50px; height: 50px;"></td>
        <td><?= $item['name']; ?></td>
        <td><?= $item['slug']; ?></td>
        <td>
            <a href="" class="btn btn-sm btn-info"><i class="fe fe-edit"></i></a>
            <a href="" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></a>
        </td>
    </tr>
<?php endforeach; ?>

<?php foreach ($product as $i => $item) : ?>
    <tr>
        <td><?= $i + 1; ?></td>
        <td><img src="<?= $item['image']; ?>" alt="" class="rounded-lg" style="width: 70px; height: 70px;"></td>
        <td><?= $item['name']; ?></td>
        <td><?= $item['slug']; ?></td>
        <td><?= 'Rp ' . number_format($item['price']); ?></td>
        <td><?= number_format($item['discon']); ?></td>
        <td><?= number_format($item['min_buy_discon']); ?></td>
        <td><?= number_format($item['stock']); ?></td>
        <td>
            <a href="" class="btn btn-sm btn-info"><i class="fe fe-edit"></i></a>
            <a href="" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></a>
        </td>
    </tr>
<?php endforeach; ?>