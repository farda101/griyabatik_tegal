# 🧪 TESTING GUIDE - Laporan Keuangan

## ✅ Verifikasi Sistem

### 1. Route Verification

**Command**:
```bash
php artisan route:list | grep keuangan
```

**Expected Output**:
```
✓ GET|HEAD  admin/laporan-keuangan/pemasukan
✓ GET|HEAD  admin/laporan-keuangan/pemasukan/export
✓ GET|HEAD  admin/laporan-keuangan/pengeluaran
✓ GET|HEAD  admin/laporan-keuangan/pengeluaran/export
```

### 2. File Verification

**Created Files**:
```
✓ app/Http/Controllers/Admin/LaporanKeuanganController.php (206 lines)
✓ app/Exports/LaporanKeuanganExport.php (173 lines)
✓ resources/views/admin/laporan_keuangan/pemasukan.blade.php (159 lines)
✓ resources/views/admin/laporan_keuangan/pengeluaran.blade.php (188 lines)
```

**Modified Files**:
```
✓ routes/web.php (added import & 4 routes)
✓ resources/views/layouts/navigation.blade.php (added menu items)
```

### 3. Database Verification

**Check if required tables exist**:
```bash
php artisan tinker
>>> Schema::hasTable('penjualan')      # Should be true
>>> Schema::hasTable('reservasis')     # Should be true
>>> Schema::hasTable('penggunaan_bahans')  # Should be true
>>> Schema::hasTable('stock_bahans')   # Should be true
```

**Check if data exists**:
```bash
>>> DB::table('penjualan')->count()      # Should be > 0
>>> DB::table('penggunaan_bahans')->count()  # Should be > 0
>>> DB::table('reservasis')->where('status_pembayaran', 'paid')->count()  # Should be > 0
```

---

## 🚀 Manual Testing Steps

### Test 1: Navigation Access (Desktop)

**Steps**:
1. Login as superadmin
2. Look at top navigation bar
3. Find "Laporan" dropdown menu
4. Hover over it

**Expected Result**:
- ✓ Dropdown appears
- ✓ Shows "Laporan Penjualan", "Laporan Stok", "Laporan Reservasi"
- ✓ Shows separator line
- ✓ Shows "📊 Laporan Pemasukan"
- ✓ Shows "💰 Laporan Pengeluaran"

### Test 2: Navigate to Pemasukan

**Steps**:
1. Click "📊 Laporan Pemasukan" from menu
2. Should go to: `/admin/laporan-keuangan/pemasukan`

**Expected Result**:
- ✓ Page loads without error
- ✓ Title shows "Laporan Pemasukan"
- ✓ Subtitle shows "Laporan pendapatan dari penjualan produk dan workshop"
- ✓ Shows 3 statistics cards (Penjualan, Workshop, Total)
- ✓ Shows date filter form
- ✓ Shows "Filter" button and "Export Excel" button
- ✓ Shows table with data (if data exists)

### Test 3: Date Filter on Pemasukan

**Steps**:
1. On Pemasukan page
2. Enter "Tanggal Dari": Select a date (e.g., 2025-01-01)
3. Enter "Tanggal Sampai": Select a date (e.g., 2025-11-30)
4. Click "Filter" button

**Expected Result**:
- ✓ Page reloads with filtered data
- ✓ Statistics cards update with new values
- ✓ Table shows only data within selected date range
- ✓ URL shows: `?tanggal_dari=2025-01-01&tanggal_sampai=2025-11-30`

### Test 4: Export Pemasukan

**Steps**:
1. On Pemasukan page (with or without filter)
2. Click "Export Excel" button

**Expected Result**:
- ✓ Excel file downloads
- ✓ Filename: `Laporan_Pemasukan_[start_date]_sampai_[end_date].xlsx`
- ✓ File contains:
  - Header row (bold, blue background)
  - Data rows with formatted currency
  - Summary row (bold, light blue background)

### Test 5: Navigate to Pengeluaran

**Steps**:
1. Click "💰 Laporan Pengeluaran" from menu
2. Should go to: `/admin/laporan-keuangan/pengeluaran`

**Expected Result**:
- ✓ Page loads without error
- ✓ Title shows "Laporan Pengeluaran"
- ✓ Subtitle shows "Laporan biaya dari penggunaan bahan dan material"
- ✓ Shows 2 statistics cards (Total, Jumlah Item)
- ✓ Shows date filter form
- ✓ Shows "Filter" button and "Export Excel" button
- ✓ If data exists:
  - Shows category breakdown section
  - Shows distribution chart with progress bars
  - Shows detailed table

### Test 6: Date Filter on Pengeluaran

**Steps**:
1. On Pengeluaran page
2. Enter "Tanggal Dari": Select a date
3. Enter "Tanggal Sampai": Select a date
4. Click "Filter" button

**Expected Result**:
- ✓ Page reloads with filtered data
- ✓ Statistics cards update
- ✓ Category breakdown updates
- ✓ Table shows only filtered data
- ✓ Progress bars recalculate percentages

### Test 7: Export Pengeluaran

**Steps**:
1. On Pengeluaran page
2. Click "Export Excel" button

**Expected Result**:
- ✓ Excel file downloads
- ✓ Filename: `Laporan_Pengeluaran_[start_date]_sampai_[end_date].xlsx`
- ✓ File contains proper formatting

### Test 8: Mobile Navigation

**Steps**:
1. Login as superadmin
2. Open page on mobile/small screen
3. Click hamburger menu (☰)

**Expected Result**:
- ✓ Mobile menu appears
- ✓ Tap on "Laporan"
- ✓ Submenu expands
- ✓ Shows all laporan options including Pemasukan & Pengeluaran
- ✓ Click links navigate correctly

### Test 9: No Data State

**Steps**:
1. On Pemasukan/Pengeluaran page
2. Select a date range with no data

**Expected Result**:
- ✓ Shows "Tidak ada data pemasukan untuk periode ini" (for pemasukan)
- ✓ Shows "Tidak ada data pengeluaran untuk periode ini" (for pengeluaran)
- ✓ Shows icon and message centered
- ✓ No errors in console

### Test 10: Responsive Design

**Steps**:
1. Open Pemasukan/Pengeluaran page
2. Resize browser to different sizes:
   - Desktop (1024px+)
   - Tablet (768px-1023px)
   - Mobile (< 768px)

**Expected Result**:
- ✓ Desktop: Cards side-by-side, full table
- ✓ Tablet: Cards stacked, scrollable table
- ✓ Mobile: Single column, optimized table
- ✓ All buttons are touch-friendly
- ✓ No horizontal scrolling issues

---

## 🧬 Code Testing

### Test Controller Methods

```bash
php artisan tinker

# Test pemasukan query
$data = \App\Http\Controllers\Admin\LaporanKeuanganController::class;
// Simulate pemasukan query
DB::table('penjualan')->whereBetween('tanggal_penjualan', [now()->startOfMonth(), now()])->get();

# Test pengeluaran query
DB::table('penggunaan_bahans')->whereBetween('tanggal_penggunaan', [now()->startOfMonth(), now()])->get();
```

### Test Export Class

```bash
# In tinker
$export = new \App\Exports\LaporanKeuanganExport('pemasukan', now()->startOfMonth(), now());
$export->collection(); # Should return collection of data
```

---

## 📊 Data Validation

### Pemasukan Validation

**Penjualan Source**:
- [x] Queries `penjualan` table
- [x] Filters by `tanggal_penjualan`
- [x] Sums `total_harga`
- [x] Groups by date
- [x] Sorted DESC by date

**Workshop Source**:
- [x] Queries `reservasis` table
- [x] Filters by `status_pembayaran = 'paid'`
- [x] Joins with `jadwal_workshops` and `paket_workshops`
- [x] Filters workshop date by selected range
- [x] Uses `total_harga` field
- [x] Sorted DESC by created_at

### Pengeluaran Validation

**Material Usage Source**:
- [x] Queries `penggunaan_bahans` table
- [x] Joins with `stock_bahans`
- [x] Filters by `tanggal_penggunaan`
- [x] Sums `qty_cost`
- [x] Groups by category
- [x] Calculates percentages

---

## 🔒 Security Testing

### Authorization Test

**Steps**:
1. Login as non-superadmin user (e.g., kasir)
2. Try to access `/admin/laporan-keuangan/pemasukan`

**Expected Result**:
- ✓ Redirect to home or dashboard
- ✓ Show error/forbidden message
- ✓ No data exposed

### SQL Injection Test

**Steps**:
1. Try to inject SQL via date parameters
2. Example: `?tanggal_dari=2025-01-01 OR 1=1`

**Expected Result**:
- ✓ Query is safely bound
- ✓ No SQL injection occurs
- ✓ Invalid dates are ignored

---

## 📈 Performance Testing

### Query Count

**Monitor SQL queries**:
```bash
DB::enableQueryLog();
// Visit pemasukan page
echo count(DB::getQueryLog()); # Should be minimal (< 10)
```

### Page Load Time

**Expected Load Time**:
- Pemasukan page: < 2 seconds
- Pengeluaran page: < 2 seconds
- Export: < 5 seconds

---

## 🐛 Troubleshooting

### Issue: "Route not found"

**Solution**:
```bash
php artisan cache:clear
php artisan route:cache
php artisan view:clear
```

### Issue: "No data showing"

**Check**:
1. Login as superadmin
2. Verify data exists:
   ```bash
   php artisan tinker
   >>> DB::table('penjualan')->count()
   >>> DB::table('penggunaan_bahans')->count()
   ```
3. Check date filters are not too restrictive

### Issue: "Export fails"

**Check**:
1. Maatwebsite/Excel installed: `composer show maatwebsite/laravel-excel`
2. Storage permissions: `chmod -R 775 storage/`
3. Check logs: `tail -f storage/logs/laravel.log`

### Issue: "Menu not showing"

**Check**:
1. User role is superadmin
2. Cache cleared: `php artisan cache:clear`
3. Inspect browser for JavaScript errors

---

## ✅ Pre-Launch Checklist

- [ ] All routes registered and accessible
- [ ] Database tables exist and have data
- [ ] Views render without errors
- [ ] Navigation menu visible for superadmin
- [ ] Date filters work correctly
- [ ] Export functionality works
- [ ] Mobile menu works
- [ ] Responsive design verified
- [ ] Security checks passed
- [ ] Performance acceptable
- [ ] No console errors
- [ ] No 404/500 errors

---

## 📋 Sign-Off

- **Tested By**: -
- **Date**: -
- **Status**: ⏳ Pending Manual Testing
- **Notes**: -
