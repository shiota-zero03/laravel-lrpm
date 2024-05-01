<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function(){
	return view('pages.auth.login');
})->name('login');
Route::get('/registrasi', function(){
	return view('pages.auth.register');
})->name('register');

Route::controller(\App\Http\Controllers\Admin\Dropdown\TemaController::class)->prefix('tema')->group(function(){
	Route::get('/', 'getAllJson');
	Route::get('/riset/{id}', 'getByIdRisetJson');
	Route::get('/tema/{id}', 'getTopicByIdTemaJson');
});

Route::controller(\App\Http\Controllers\AuthController::class)->name('auth.')->group(function(){
	Route::post('/', 'login_process')->name('login');
	Route::get('/get-prodi/{id_fakultas}', 'getprodi')->name('getprodi');
	Route::post('/registrasi', 'register_process')->name('register');
});

Route::middleware('auth')->group(function(){
    Route::get('/penilaian/laporan-akhir/{id}', [\App\Http\Controllers\PenilaianController::class, 'showPenilaian'])->name('penilaian.submission');
    Route::get('/penilaian/laporan-final/{id}', [\App\Http\Controllers\PenilaianController::class, 'showFinalPenilaian'])->name('penilaian.final.submission');

    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

	Route::prefix('/admin')->name('admin.')->group(function(){
		Route::prefix('/notification')->name('notification.')->controller(\App\Http\Controllers\Admin\NotificationController::class)->group(function(){
			Route::get('/{id}', 'read_notification')->name('read');
            Route::get('read/all', 'read_all_notification')->name('read-all');
		});
		Route::controller(\App\Http\Controllers\Admin\ProfileController::class)->group(function(){
			Route::get('/profile', 'index')->name('profile.index');
			Route::post('/profile', 'update')->name('profile.update');
			Route::get('/profile/get-prodi/{id_fakultas}', 'getProdi')->name('profile.getProdi');
		});

		Route::controller(\App\Http\Controllers\Admin\DashboardController::class)->group(function(){
			Route::get('/', 'index')->name('beranda.index');
			Route::get('/dashboard', 'dashboard')->name('dashboard.index');
            Route::get('/export', 'export')->name('dashboard.export');
            Route::get('/database-usulan/export', 'exportDatabase')->name('dashboard.export.database');
		});

		Route::prefix('/dropdown')->name('dropdown.')->group(function(){
			Route::controller(\App\Http\Controllers\Admin\Dropdown\PositionController::class)->name('jabatan.')->prefix('/jabatan')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
			Route::controller(\App\Http\Controllers\Admin\Dropdown\FakultasController::class)->name('fakultas.')->prefix('/fakultas')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
			Route::controller(\App\Http\Controllers\Admin\Dropdown\ProdiController::class)->name('prodi.')->prefix('/program-studi')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
			Route::controller(\App\Http\Controllers\Admin\Dropdown\MitraFundingController::class)->name('mitra_funding.')->prefix('/pendanaan-mitra')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
			Route::controller(\App\Http\Controllers\Admin\Dropdown\DokumenTemplateController::class)->name('template.')->prefix('/dokumen-template')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::post('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
			Route::controller(\App\Http\Controllers\Admin\Dropdown\SkemaController::class)->name('skema.')->prefix('/skema')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
			Route::controller(\App\Http\Controllers\Admin\Dropdown\RisetUnggulanController::class)->name('riset.')->prefix('/riset-unggulan')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
			Route::controller(\App\Http\Controllers\Admin\Dropdown\TemaController::class)->name('tema.')->prefix('/tema')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
			Route::controller(\App\Http\Controllers\Admin\Dropdown\TopikController::class)->name('topik.')->prefix('/topik')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
			Route::controller(\App\Http\Controllers\Admin\Dropdown\LuaranController::class)->name('luaran.')->prefix('/target-luaran')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
			Route::controller(\App\Http\Controllers\Admin\Dropdown\ItemRABController::class)->name('rab.')->prefix('/item-rab')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
			});
		});

        Route::controller(\App\Http\Controllers\Admin\ConfigController::class)->prefix('/config')->name('config.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
        });

		Route::prefix('/{type}')->group(function(){
			Route::controller(\App\Http\Controllers\Admin\Submission\UsulanBaruController::class)->name('usulan-baru.')->prefix('usulan-baru')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
			Route::controller(\App\Http\Controllers\Admin\Submission\ProposalController::class)->name('proposal.')->prefix('proposal')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
				Route::post('/{submission_code}/upload-spk', 'spkUpload')->name('spkUpload');
			});
            Route::controller(\App\Http\Controllers\Admin\Submission\SPKController::class)->name('spk.')->prefix('spk')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
				Route::post('/{submission_code}/upload-spk', 'spkUpload')->name('spkUpload');
			});
			Route::controller(\App\Http\Controllers\Admin\Submission\LaporanAkhirController::class)->name('laporan-akhir.')->prefix('laporan-akhir')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
            Route::controller(\App\Http\Controllers\Admin\Submission\MonevController::class)->name('monev.')->prefix('monev')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
            Route::controller(\App\Http\Controllers\Admin\Submission\LaporanFinalController::class)->name('laporan-final.')->prefix('laporan-final')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
			Route::controller(\App\Http\Controllers\Admin\Submission\PublikasiController::class)->name('publikasi.')->prefix('publikasi')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
		});

		Route::controller(\App\Http\Controllers\Admin\UserController::class)->prefix('/daftar-pengguna')->group(function(){
			Route::prefix('/{role}')->name('user.')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::post('/', 'store')->name('store');
				Route::get('/json', 'json')->name('json');
				Route::get('/{id}', 'show')->name('show');
				Route::put('/{id}', 'update')->name('update');
				Route::delete('/{id}', 'destroy')->name('destroy');
				Route::get('/get-prodi/{fakultas_id}', 'getProdi');
				Route::put('/verifikasi/{id}', 'verifikasi')->name('verifikasi');
			});
		});
	});

    Route::prefix('/dosen')->name('dosen.')->group(function(){
		Route::prefix('/notification')->name('notification.')->controller(\App\Http\Controllers\Dosen\NotificationController::class)->group(function(){
			Route::get('/{id}', 'read_notification')->name('read');
            Route::get('read/all', 'read_all_notification')->name('read-all');
		});

		Route::controller(\App\Http\Controllers\Dosen\DashboardController::class)->group(function(){
			Route::get('/', 'index')->name('beranda.index');
		});

		Route::controller(\App\Http\Controllers\Dosen\ProfileController::class)->group(function(){
			Route::get('/profile', 'index')->name('profile.index');
			Route::post('/profile', 'update')->name('profile.update');
			Route::get('/profile/get-prodi/{id_fakultas}', 'getProdi')->name('profile.getProdi');
		});

		Route::controller(\App\Http\Controllers\Dosen\UsulanBaruController::class)->group(function(){
			Route::prefix('usulan-baru/{type}')->name('usulan-baru.')->group(function(){
				Route::get('/', 'index')->name('index');
                Route::delete('/delete/{id}', 'delete')->name('delete');
				Route::get('/show/{id}', 'show')->name('show');
				Route::get('/detail/{id}', 'detail')->name('detail');
				Route::get('/buat-usulan-baru', 'firstOnCreate')->name('create');
				Route::prefix('/{submission_code}')->group(function(){
					Route::get('/', 'identitasPengusul')->name('identitas-usulan');
					Route::post('/{status}/{fase}/{event}', 'storeUsulan')->name('store-usulan');

					Route::get('check-participant/{role}', 'checkParticipant')->name('check-participant');
					Route::get('tambah-participant/{role}', 'getParticipant')->name('get-participant');
					Route::post('tambah-participant/{role}', 'tambahParticipant')->name('tambah-participant');
					Route::get('tambah-participant/{role}/{id}', 'showParticipant')->name('show-participant');
					Route::put('tambah-participant/{role}/{id}', 'updateParticipant')->name('update-participant');
					Route::delete('delete-participant/{id}', 'deleteParticipant')->name('delete-participant');

					Route::get('tambah-rab', 'getRAB')->name('get-rab');
					Route::post('tambah-rab', 'tambahRAB')->name('tambah-rab');
					Route::delete('delete-rab/{id}', 'deleteRAB')->name('delete-rab');
				});
			});
		});
		Route::controller(\App\Http\Controllers\Dosen\ProposalController::class)->group(function(){
			Route::prefix('proposal/{type}')->name('proposal.')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/show/{id}', 'show')->name('show');
				Route::get('/detail/{id}', 'detail')->name('detail');
				Route::prefix('/submit-proposal/{submission_code}')->group(function(){
					Route::get('/', 'proposal')->name('update');
					Route::post('/', 'updateProposal')->name('update');
					Route::post('/send', 'submitProposal')->name('submit');
					Route::post('/{status}/{event}', 'storeUsulan')->name('store-usulan');
				});
			});
		});
        Route::controller(\App\Http\Controllers\Dosen\SPKController::class)->group(function(){
			Route::prefix('spk/{type}')->name('spk.')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/show/{id}', 'show')->name('show');
				Route::get('/detail/{id}', 'detail')->name('detail');
				Route::prefix('/submit-spk/{submission_code}')->group(function(){
					Route::get('/', 'spk')->name('update');
					Route::post('/', 'updatespk')->name('update');
					Route::post('/send', 'submitspk')->name('submit');
					Route::post('/{status}/{event}', 'storeUsulan')->name('store-usulan');
				});
			});
		});
		Route::controller(\App\Http\Controllers\Dosen\LaporanAkhirController::class)->group(function(){
			Route::prefix('laporan-akhir/{type}')->name('laporan-akhir.')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/show/{id}', 'show')->name('show');
				Route::get('/detail/{id}', 'detail')->name('detail');
				Route::prefix('/submit-laporan/{submission_code}')->group(function(){
					Route::get('/', 'proposal')->name('update');
					Route::post('/', 'updateLaporan')->name('update');
					Route::post('/send', 'submitLaporan')->name('submit');
					Route::post('/{status}/{event}', 'storeUsulan')->name('store-usulan');
				});
			});
		});
        Route::controller(\App\Http\Controllers\Dosen\MonevController::class)->group(function(){
			Route::prefix('monev/{type}')->name('monev.')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/show/{id}', 'show')->name('show');
				Route::get('/detail/{id}', 'detail')->name('detail');
				Route::prefix('/submit-monev/{submission_code}')->group(function(){
					Route::get('/', 'proposal')->name('update');
					Route::post('/', 'updateMonev')->name('update');
					Route::post('/send', 'submitMonev')->name('submit');
					Route::post('/{status}/{event}', 'storeUsulan')->name('store-usulan');
				});
			});
		});
        Route::controller(\App\Http\Controllers\Dosen\LaporanFinalController::class)->group(function(){
			Route::prefix('laporan-final/{type}')->name('laporan-final.')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/show/{id}', 'show')->name('show');
				Route::get('/detail/{id}', 'detail')->name('detail');
				Route::prefix('/submit-laporan/{submission_code}')->group(function(){
					Route::get('/', 'proposal')->name('update');
					Route::post('/', 'updateLaporan')->name('update');
					Route::post('/send', 'submitLaporan')->name('submit');
					Route::post('/{status}/{event}', 'storeUsulan')->name('store-usulan');
				});
			});
		});
		Route::controller(\App\Http\Controllers\Dosen\PublikasiController::class)->group(function(){
			Route::prefix('publikasi/{type}')->name('publikasi.')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/show/{id}', 'show')->name('show');
				Route::get('/detail/{id}', 'detail')->name('detail');
				Route::prefix('/submit-laporan/{submission_code}')->group(function(){
					Route::get('/', 'proposal')->name('update');
					Route::post('/', 'updateLaporan')->name('update');
					Route::post('/send', 'submitLaporan')->name('submit');
					Route::post('/{status}/{event}', 'storeUsulan')->name('store-usulan');
				});
			});
		});
	});

    Route::prefix('/prodi')->name('prodi.')->group(function(){
		Route::prefix('/notification')->name('notification.')->controller(\App\Http\Controllers\Prodi\NotificationController::class)->group(function(){
			Route::get('/{id}', 'read_notification')->name('read');
            Route::get('read/all', 'read_all_notification')->name('read-all');
		});

		Route::controller(\App\Http\Controllers\Prodi\ProfileController::class)->group(function(){
			Route::get('/profile', 'index')->name('profile.index');
			Route::post('/profile', 'update')->name('profile.update');
			Route::get('/profile/get-prodi/{id_fakultas}', 'getProdi')->name('profile.getProdi');
		});

		Route::controller(\App\Http\Controllers\Prodi\DashboardController::class)->group(function(){
			Route::get('/', 'index')->name('beranda.index');
			Route::get('/dashboard', 'dashboard')->name('dashboard.index');
		});

		Route::prefix('/{type}')->group(function(){
			Route::controller(\App\Http\Controllers\Prodi\Submission\UsulanBaruController::class)->name('usulan-baru.')->prefix('usulan-baru')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
			Route::controller(\App\Http\Controllers\Prodi\Submission\ProposalController::class)->name('proposal.')->prefix('proposal')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
			Route::controller(\App\Http\Controllers\Prodi\Submission\LaporanAkhirController::class)->name('laporan-akhir.')->prefix('laporan-akhir')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
            Route::controller(\App\Http\Controllers\Prodi\Submission\MonevController::class)->name('monev.')->prefix('monev')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
            Route::controller(\App\Http\Controllers\Prodi\Submission\LaporanFinalController::class)->name('laporan-final.')->prefix('laporan-final')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
			Route::controller(\App\Http\Controllers\Prodi\Submission\PublikasiController::class)->name('publikasi.')->prefix('publikasi')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
		});
	});

    Route::prefix('/fakultas')->name('fakultas.')->group(function(){
		Route::prefix('/notification')->name('notification.')->controller(\App\Http\Controllers\Fakultas\NotificationController::class)->group(function(){
			Route::get('/{id}', 'read_notification')->name('read');
            Route::get('read/all', 'read_all_notification')->name('read-all');
		});

		Route::controller(\App\Http\Controllers\Fakultas\DashboardController::class)->group(function(){
			Route::get('/', 'index')->name('beranda.index');
			Route::get('/dashboard', 'dashboard')->name('dashboard.index');
		});

		Route::prefix('/{type}')->group(function(){
			Route::controller(\App\Http\Controllers\Fakultas\Submission\UsulanBaruController::class)->name('usulan-baru.')->prefix('usulan-baru')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
			Route::controller(\App\Http\Controllers\Fakultas\Submission\ProposalController::class)->name('proposal.')->prefix('proposal')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
			Route::controller(\App\Http\Controllers\Fakultas\Submission\LaporanAkhirController::class)->name('laporan-akhir.')->prefix('laporan-akhir')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
            Route::controller(\App\Http\Controllers\Fakultas\Submission\MonevController::class)->name('monev.')->prefix('monev')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
            Route::controller(\App\Http\Controllers\Fakultas\Submission\LaporanFinalController::class)->name('laporan-final.')->prefix('laporan-final')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
			Route::controller(\App\Http\Controllers\Fakultas\Submission\PublikasiController::class)->name('publikasi.')->prefix('publikasi')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
		});
	});

    Route::prefix('/reviewer')->name('reviewer.')->group(function(){
		Route::prefix('/notification')->name('notification.')->controller(\App\Http\Controllers\Reviewer\NotificationController::class)->group(function(){
			Route::get('/{id}', 'read_notification')->name('read');
            Route::get('read/all', 'read_all_notification')->name('read-all');
		});

		Route::controller(\App\Http\Controllers\Reviewer\DashboardController::class)->group(function(){
			Route::get('/', 'index')->name('beranda.index');
			Route::get('/dashboard', 'dashboard')->name('dashboard.index');
		});
		Route::controller(\App\Http\Controllers\Reviewer\ProfileController::class)->group(function(){
			Route::get('/profile', 'index')->name('profile.index');
			Route::post('/profile', 'update')->name('profile.update');
			Route::get('/profile/get-prodi/{id_fakultas}', 'getProdi')->name('profile.getProdi');
		});

		Route::prefix('/{type}')->group(function(){
			Route::controller(\App\Http\Controllers\Reviewer\Submission\UsulanBaruController::class)->name('usulan-baru.')->prefix('usulan-baru')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
			Route::controller(\App\Http\Controllers\Reviewer\Submission\ProposalController::class)->name('proposal.')->prefix('proposal')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
			Route::controller(\App\Http\Controllers\Reviewer\Submission\LaporanAkhirController::class)->name('laporan-akhir.')->prefix('laporan-akhir')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
            Route::controller(\App\Http\Controllers\Reviewer\Submission\MonevController::class)->name('monev.')->prefix('monev')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
                Route::post('/{submission_code}', 'action')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
			});
			Route::controller(\App\Http\Controllers\Reviewer\Submission\PublikasiController::class)->name('publikasi.')->prefix('publikasi')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
            Route::controller(\App\Http\Controllers\Reviewer\Submission\LaporanFinalController::class)->name('laporan-final.')->prefix('laporan-final')->group(function(){
				Route::get('/', 'index')->name('index');
				Route::get('/{submission_code}', 'show')->name('show');
				Route::get('/tracking/{id}', 'tracking')->name('tracking');
				Route::post('/aksi/{id}/{aksi}', 'action')->name('action');
			});
		});
	});
});
