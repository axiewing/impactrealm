<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-6">
        <div class="bg-secondary rounded p-4 px-sm-5 my-4 mx-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <a href="<?php echo base_url(); ?>/" class="">
                    <img id="top_logo" class="logo_nav" src="<?php echo base_url(); ?>/img/logo_.png" /></a>
                <h3><?= lang('Auth.login') ?></h3>
            </div>

            <?php if (session('error') !== null) : ?>
                <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
            <?php elseif (session('errors') !== null) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (is_array(session('errors'))) : ?>
                        <?php foreach (session('errors') as $error) : ?>
                            <?= $error ?>
                            <br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= session('errors') ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php if (session('message') !== null) : ?>
                <div class="alert alert-success" role="alert"><?= session('message') ?></div>
            <?php endif ?>

            <form action="<?= url_to('login') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="form-floating mb-2">
                    <input id="fel1" type="email" class="form-control" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
                    <label for="fel1">Email</label>
                </div>


                <!-- Password -->
                <div class="form-floating mb-2">
                    <input id="fel3" type="password" class="form-control" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required />
                    <label for="fel3">Password</label>
                </div>

                <!-- Remember me -->
                <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked<?php endif ?>>
                            <?= lang('Auth.rememberMe') ?>
                        </label>
                    </div>
                <?php endif; ?>

                <div class="d-grid col-12 col-md-8 mx-auto m-3">
                    <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.login') ?></button>
                </div>

                    <div class="d-grid col-12 col-md-8 mx-auto m-3">
                        <a class="btn  btn-info " style="color:white;" href="<?php echo base_url(); ?>/oauth/google"><img src="https://img.icons8.com/color/16/000000/google-logo.png"> <span>Signup Using Google</span></a>

                    </div>
                <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                    <p class="text-center"><?= lang('Auth.forgotPassword') ?> <a href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a></p>
                <?php endif ?>

                <?php if (setting('Auth.allowRegistration')) : ?>
                    <p class="text-center"><?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a></p>
                <?php endif ?>

            </form>
        </div>
    </div>
</div>

<script>
    const base_url = "<?php echo base_url(); ?>";
</script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="<?php echo base_url(); ?>/js/main.js"></script>
<?= $this->endSection() ?>