-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 05:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ql_vanphongpham`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitietdondathang`
--

CREATE TABLE `chitietdondathang` (
  `MaDH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `ThanhTien` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chitietdondathang`
--

INSERT INTO `chitietdondathang` (`MaDH`, `MaSP`, `SoLuong`, `ThanhTien`) VALUES
(1, 2, 10, 750000),
(2, 11, 20, 300000),
(3, 14, 30, 135000);

-- --------------------------------------------------------

--
-- Table structure for table `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `MaHD` int(10) NOT NULL,
  `MaSP` int(10) NOT NULL,
  `GiaBan` float NOT NULL,
  `SoLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`MaHD`, `MaSP`, `GiaBan`, `SoLuong`) VALUES
(1, 10, 14000, 10),
(2, 10, 14000, 5),
(3, 16, 2500, 10),
(4, 5, 16000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `chucvu`
--

CREATE TABLE `chucvu` (
  `MaCV` int(10) NOT NULL,
  `TenCV` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chucvu`
--

INSERT INTO `chucvu` (`MaCV`, `TenCV`) VALUES
(1, 'Giám đốc'),
(2, 'Nhân viên'),
(3, 'Quản lý');

-- --------------------------------------------------------

--
-- Table structure for table `dondathang`
--

CREATE TABLE `dondathang` (
  `MaDDH` int(10) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `NgayDatHang` date NOT NULL,
  `TrangThaiDonHang` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TongGiaTriDonHang` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dondathang`
--

INSERT INTO `dondathang` (`MaDDH`, `MaKH`, `NgayDatHang`, `TrangThaiDonHang`, `TongGiaTriDonHang`) VALUES
(1, 3, '2024-01-01', 'Đã giao', 750000),
(2, 3, '2024-02-28', 'Đã giao', 300000),
(3, 1, '2024-03-01', 'Đang xử lý', 135000);

-- --------------------------------------------------------

--
-- Table structure for table `hinhanh`
--

CREATE TABLE `hinhanh` (
  `MaSP` int(10) NOT NULL,
  `Hinh` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hinhanh`
--

INSERT INTO `hinhanh` (`MaSP`, `Hinh`) VALUES
(1, 'Giay-in-Double-A-A4-80gsm_1.jpg'),
(1, 'Giay-in-Double-A-A4-80gsm_2.jpg'),
(1, 'Giay-in-Double-A-A4-80gsm_3.jpg'),
(2, 'Giay-in-Double-A-A-70gsm_1.jpg'),
(2, 'Giay-in-Double-A-A-70gsm_2.jpg'),
(2, 'Giay-in-Double-A-A-70gsm_3.jpg'),
(3, 'Giay-in-IK_Plus-A4-70gsm_1.jpg'),
(3, 'Giay-in-IK_Plus-A4-70gsm_2.jpg'),
(3, 'Giay-in-IK_Plus-A4-70gsm_3.jpg'),
(4, 'Giay-in-IK_Plus-A4-80gsm_1.jpg'),
(4, 'Giay-in-IK_Plus-A4-80gsm_2.jpg'),
(4, 'Giay-in-IK_Plus-A4-80gsm_2.jpg'),
(5, 'Tap-120-trang-kho-lon-Campus_1.jpg'),
(5, 'Tap-120-trang-kho-lon-Campus_2.jpg'),
(5, 'Tap-120-trang-kho-lon-Campus_3.jpg'),
(6, 'Vo-4-o-ly-96-trang_1.jpg'),
(6, 'Vo-4-o-ly-96-trang_2.jpg'),
(6, 'Vo-4-o-ly-96-trang_3.jpg'),
(7, 'Tap-100-trang-VBook-Sinh-vien-heo_1.jpg'),
(7, 'Tap-100-trang-VBook-Sinh-vien-heo_2.jpg'),
(7, 'Tap-100-trang-VBook-Sinh-vien-heo_3.jpg'),
(8, 'Tap-200-trang-VBook-Sinh-vien-heo_1.jpg'),
(8, 'Tap-200-trang-VBook-Sinh-vien-heo_2.jpg'),
(8, 'Tap-200-trang-VBook-Sinh-vien-heo_3.jpg'),
(9, 'Tap-200-trang-Tien-Phat-Lang-Huong_1.jpg'),
(9, 'Tap-200-trang-Tien-Phat-Lang-Huong_2.jpg'),
(9, 'Tap-200-trang-Tien-Phat-Lang-Huong_3.jpg'),
(10, 'vo-4-o-ly-class-ami-96-trang_1.jpg'),
(10, 'vo-4-o-ly-class-ami-96-trang_2.jpg'),
(10, 'vo-4-o-ly-class-ami-96-trang_3.jpg'),
(11, 'but-xoa-thien-long-fo-cp01_1.jpg'),
(11, 'but-xoa-thien-long-fo-cp01_2.jpg'),
(11, 'but-xoa-thien-long-fo-cp01_3.jpg'),
(12, 'but-xoa-thien-long-fo-cp02_1.jpg'),
(12, 'but-xoa-thien-long-fo-cp02_2.jpg'),
(12, 'but-xoa-thien-long-fo-cp02_3.jpg'),
(13, 'but-long-bang-thien-long-wb-02_1.jpg'),
(13, 'but-long-bang-thien-long-wb-02_2.jpg'),
(13, 'but-long-bang-thien-long-wb-02_3.jpg'),
(14, 'but-bi-thien-long-tl-027_1.jpg'),
(14, 'but-bi-thien-long-tl-027_2.jpg'),
(14, 'but-bi-thien-long-tl-027_3.jpg'),
(15, 'but-bi-thien-long-tl-079_1.jpg'),
(15, 'but-bi-thien-long-tl-079_2.jpg'),
(15, 'but-bi-thien-long-tl-079_3.jpg'),
(16, 'But-Chi-Chuot-Gstar-P333-4B_1.jpg'),
(16, 'But-Chi-Chuot-Gstar-P333-4B_2.jpg'),
(16, 'But-Chi-Chuot-Gstar-P333-4B_3.jpg'),
(17, 'But-Chi-Chuot-Gstar-3B_1.jpg'),
(17, 'But-Chi-Chuot-Gstar-3B_2.jpg'),
(17, 'But-Chi-Chuot-Gstar-3B_3.jpg'),
(18, 'Gom-Pentel-H.05_1.jpg'),
(18, 'Gom-Pentel-H.05_2.jpg'),
(18, 'Gom-Pentel-H.05_3.jpg'),
(19, 'chuot-chi-01-lo-hinh-chu-nhat_1.jpg'),
(19, 'chuot-chi-01-lo-hinh-chu-nhat_2.jpg'),
(19, 'chuot-chi-01-lo-hinh-chu-nhat_3.jpg'),
(20, 'bang-keo-trong-5f_1.jpg'),
(20, 'bang-keo-trong-5f_2.jpg'),
(20, 'bang-keo-trong-5f_3.jpg'),
(21, 'atlat-dia-ly-viet-nam_1.jpg'),
(21, 'atlat-dia-ly-viet-nam_2.jpg'),
(21, 'atlat-dia-ly-viet-nam_3.jpg'),
(22, 'Bo-sach-giao-khoa-lop-1_1.jpg'),
(22, 'Bo-sach-giao-khoa-lop-1_2.jpg'),
(22, 'Bo-sach-giao-khoa-lop-1_3.jpg'),
(23, 'keo-kho-TL-G019_1.jpg'),
(23, 'keo-kho-TL-G019_2.jpg'),
(23, 'keo-kho-TL-G019_3.jpg'),
(24, 'keo_dan_giay_thien_long_diem_10_g-08_1.jpg'),
(24, 'keo_dan_giay_thien_long_diem_10_g-08_2.jpg'),
(24, 'keo_dan_giay_thien_long_diem_10_g-08_3.jpg'),
(25, 'may-tinh-casio-fx-580vn_1.jpg'),
(25, 'may-tinh-casio-fx-580vn_2.jpg'),
(25, 'may-tinh-casio-fx-580vn_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `MaHD` int(11) NOT NULL,
  `NgayBan` date NOT NULL,
  `TongTienHoaDon` float NOT NULL,
  `MaNV` int(10) NOT NULL,
  `MaKM` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`MaHD`, `NgayBan`, `TongTienHoaDon`, `MaNV`, `MaKM`) VALUES
(1, '2024-01-12', 140000, 4, 1),
(2, '2024-02-21', 70000, 4, 1),
(3, '2024-03-01', 20000, 3, 4),
(4, '2024-03-01', 25600, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `HoTen_KH` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `DiaChi_KH` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SDT_KH` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Email_KH` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Password_KH` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `HoTen_KH`, `DiaChi_KH`, `SDT_KH`, `Email_KH`, `Password_KH`) VALUES
(1, 'Nguyễn Văn Minh', 'Hà Nội', '0912345678', 'vanminh1998@gmail.com', 'Minh123@'),
(2, 'Lê Thị Bình', 'Bình Dương', '0927589197', 'thoconcute123@gmail.com', 'Binh456@'),
(3, 'Lê Minh Bảo', 'Hải Phòng', '0973571563', 'leminhbao2000@gmail.com', '@minhBao987'),
(4, 'Phạm Việt Dũng', 'Bình Định', '0958174892', 'dungviet038@gmail.com', 'vietDung@482'),
(5, 'Phan Minh Tâm', 'TP.HCM', '0989673619', 'phantam992@gmail.com', 'Tamphan992@');

-- --------------------------------------------------------

--
-- Table structure for table `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `MaKM` int(10) NOT NULL,
  `TenSuKien` varchar(255) NOT NULL,
  `NgaySuKien` date NOT NULL,
  `GiaGiam` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khuyenmai`
--

INSERT INTO `khuyenmai` (`MaKM`, `TenSuKien`, `NgaySuKien`, `GiaGiam`) VALUES
(1, 'Không khuyến mãi', '2022-01-01', 0),
(2, 'Quốc tế thiếu nhiu', '2024-06-01', 0.3),
(3, 'Ngày tựu trường', '2024-08-01', 0.4),
(4, 'Vui học rộn ràng', '2024-05-01', 0.2);

-- --------------------------------------------------------

--
-- Table structure for table `loaisp`
--

CREATE TABLE `loaisp` (
  `MaLoai` int(10) NOT NULL,
  `TenLoai` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loaisp`
--

INSERT INTO `loaisp` (`MaLoai`, `TenLoai`) VALUES
(1, 'Bút'),
(2, 'Sách giáo khoa'),
(3, 'Gôm - tẩy - chuốt'),
(4, 'Sổ - tập'),
(5, 'Băng keo'),
(6, 'Kéo - hồ'),
(7, 'Máy tính'),
(8, 'Giấy');

-- --------------------------------------------------------

--
-- Table structure for table `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MaNCC` int(11) NOT NULL,
  `TenNCC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SDT_NCC` varchar(255) NOT NULL,
  `Email_NCC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `DiaChi_NCC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhacungcap`
--

INSERT INTO `nhacungcap` (`MaNCC`, `TenNCC`, `SDT_NCC`, `Email_NCC`, `DiaChi_NCC`) VALUES
(1, 'CÔNG TY TNHH KOKUYO VIỆT NAM', '022 5374 3257', 'kengo_fujii@kokuyo.com', 'Tầng 9, tòa nhà Lant, 56-58-60 Hai Bà Trưng, Q. 1, Tp. Hồ Chí Minh'),
(2, 'CÔNG TY CỔ PHẦN VĂN PHÒNG PHẨM HỒNG HÀ', '024 3652 4250', 'congty@vpphongha.com.vn', '25 Lý Thường Kiệt, P. Phan Chu Trinh, Q. Hoàn Kiếm, Hà Nội'),
(3, 'CÔNG TY TNHH SẢN XUẤT THƯƠNG MẠI DỊCH VỤ TIẾN PHÁT', '028 3964 2706', 'tapsotienphat@gmail.com', 'Số 9 Đình Nghi Xuân, P. Bình Trị Đông, Q. Bình Tân, Tp. Hồ Chí Minh'),
(4, 'CÔNG TY CỔ PHẦN GIẤY VĨNH TIẾN', '028 3912 0915', 'info@vinhtien.vn', '99 Cao Xuân Dục, P. 12, Q. 8, Tp. Hồ Chí Minh'),
(5, 'CÔNG TY TNHH SOWI S.H', '028 3973 7658', 'Sowigstar@gmail.com', '175 Thoại Ngọc Hầu, P. Phú Thạnh, Q. Tân Phú, Tp. Hồ Chí Minh'),
(6, 'CÔNG TY CỔ PHẦN TẬP ĐOÀN THIÊN LONG', '1900 866 819', 'salesonline@thienlongvn.com', 'Sofic Tower, Số 10 Đường Mai Chí Thọ, P. Thủ Thiêm, Tp Thủ Đức, Tp. Hồ Chí Minh'),
(7, 'CÔNG TY TNHH MỘT THÀNH VIÊN NHÀ XUẤT BẢN GIÁO DỤC VIỆT NAM', '024 3822 0801', 'veph@nxbgd.vn', 'Số 81 Trần Hưng Đạo, Hoàn Kiếm, Hà Nội'),
(8, 'CÔNG TY GIẤY DOUBLE A THÁI LAN', '024 3776 4822', 'cskh@doubleapaper.com.vn', 'Tòa Nhà Mecanimek, Số 4 Vũ Ngọc Phan, Q. Đống Đa, Hà Nội'),
(9, 'CÔNG TY PLUS VIỆT NAM', '025 1383 6593', 'cskh_online@plus.com.vn', 'Số 3, Đường 1A, Khu Công Nghiệp Biên Hòa II, Đồng Nai'),
(10, 'CÔNG TY TNHH SẢN XUẤT - THƯƠNG MẠI - DỊCH VỤ TÂM TÀI ĐỨC', '0352 393 674', 'bangkeotamtaiduc@gmail.com', '381/11 Lê Văn Quới, P. Bình Trị Đông A, Q. Bình Tân, Tp. Hồ Chí Minh.'),
(11, 'CÔNG TY CỔ PHẦN XNK BÌNH TÂY', '1900 2152', 'bitex@bitex.com.vn', '16 Trịnh Hoài Đức, P. 13, Q. 5, TP. Hồ Chí Minh'),
(12, 'CÔNG TY CPTM THIẾT BỊ VĂN PHÒNG SÁNG TẠO', '028 3636 8821', 'vinh.vt@stacom.vn', '43 Đường Linh Đông, Khu phố 7, P. Linh Đông, TP. Thủ Đức, TP. Hồ Chí Minh');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(10) NOT NULL,
  `HoTen_NV` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TenDangNhap` varchar(255) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `GioiTinh` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SDT_NV` varchar(20) NOT NULL,
  `Email_NV` varchar(255) NOT NULL,
  `DiaChi_NV` varchar(255) NOT NULL,
  `MaCV` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `HoTen_NV`, `TenDangNhap`, `MatKhau`, `GioiTinh`, `SDT_NV`, `Email_NV`, `DiaChi_NV`, `MaCV`) VALUES
(1, 'Trần Trạch Nguyên', 'TrachNguyen', 'nguyen123', 'Nam', '0987654321', 'nguyentt@gmail.com', 'TP.HCM', 1),
(2, 'Nguyễn Thái Khang', 'ThaiKhang', 'khang123', 'Nam', '0123456789', 'khangnt@gmail.com', 'TP.HCM', 2),
(3, 'Phạm Thiên Tân', 'ThienTan', 'tan123', 'Nam', '0975312468', 'tanpt@gmail.com', 'Cần Thơ', 2),
(4, 'Võ Đại Thành', 'DaiThanh', 'thanh123', 'Nam', '0986421357', 'thanhvd@gmail.com', 'TP.HCM', 3),
(5, 'Nguyễn Thanh Nhã', 'ThanhNha', 'nha123', 'Nữ', '0135798642', 'nhant@gmail.com', 'Bắc Ninh', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` int(10) NOT NULL,
  `MaLoai` int(10) NOT NULL,
  `MaNCC` int(10) NOT NULL,
  `TenSP` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Gia` float NOT NULL,
  `DVT` varchar(20) NOT NULL DEFAULT 'Cái',
  `SoLuongTonKho` int(255) NOT NULL,
  `MoTaSP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `MaLoai`, `MaNCC`, `TenSP`, `Gia`, `DVT`, `SoLuongTonKho`, `MoTaSP`) VALUES
(1, 8, 8, 'Giấy A4 Double A 80 gsm', 90000, 'Ream', 200, 'Giấy A4 Double A định lượng 80gsm với độ dày cao, bề mặt giấy đẹp rất phù hợp để in photo các giáy tờ quan trọng'),
(2, 8, 8, 'Giấy A4 Double A 70 gsm', 75000, 'Ream', 300, 'Giấy in A4 Double A 70gsm là loại giấy in photo phổ biến và thông dụng được sử dụng để in - photo đóng thành cuốn hoặc dùng làm phiếu thu'),
(3, 8, 9, 'Giấy A4 IK Plus 70 gsm', 70000, 'Ream', 310, 'Giấy A4 IK Plus 70 gsm là loại giấy in photo của thương hiệu giấy IK Plus nổi tiếng, được sản xuất theo công nghệ sản xuất giấy hiện đại'),
(4, 8, 9, 'Giấy A4 IK Plus 80 gsm', 80000, 'Ream', 150, 'Giấy A4 IK Plus với định lượng 80gsm là loại giấy in có thành phần chất hóa học thấp, thân thiện với môi trường và sức khỏe người sử dụng.'),
(5, 4, 1, 'Tập 120 trang ngang khổ lớn Campus', 16000, 'Cuốn', 135, 'Tập 120 Campus có định lượng 70gsm, tập có đường kẻ, chất lượng cao cấp được khách hàng tin dùng'),
(6, 4, 1, 'Vở 4 Ly Ngang 96 Trang', 10000, 'Cuốn', 412, 'Chất lượng giấy tốt, độ trắng sáng cao, bề mặt giấy dày, không bụi giấy, viết êm tay'),
(7, 4, 4, 'Tập 100 trang Vibook Sinh viên heo', 11000, 'Cuốn', 716, 'Tập SV heo 100 trang có thiết kế bìa vở hình nổi bật, trẻ trung, bìa vở in hình nổi bật, đẹp mắt'),
(8, 4, 4, 'Tập 200 trang Vibook Sinh viên heo', 21000, 'Cuốn', 561, 'Tập SV heo 200 trang là sản phẩm sổ tập loại tốt, được khách hàng ưa chuộng tin dùng, định lượng 70gsm, tập có đường kẻ ôli'),
(9, 4, 3, 'Tập 200 trang Tiến Phát Làng Hương', 12000, 'Cuốn', 412, 'Tập 200 trang Tiến Phát Làng Hương là sản phẩm sổ tập loại tốt, được nhiều khách hàng ưa chuộng tin dùng'),
(10, 4, 2, 'Vở 4 ô ly 96 trang Hồng Hà Class Ami', 14000, 'Cuốn', 565, 'Vở 4 Ô Ly 96 Trang Hồng Hà được thiết kế với những hình ảnh bắt mắt, giúp bé hứng thú hơn với việc học'),
(11, 1, 6, 'Bút xóa nước Thiên Long CP-01', 15000, 'Cây', 381, 'Bút xóa Thiên Long CP-01 có cán bằng nhựa màu xanh dương thể hiện sự trẻ trung, năng động'),
(12, 1, 6, 'Bút xóa nước Thiên Long CP-02', 27000, 'Cây', 836, 'Bút xóa Thiên Long CP-02 có kiểu dáng thân dẹp, vừa tầm tay, thuận tiện khi sử dụng'),
(13, 1, 6, 'Bút lông bảng Thiên Long WB-02', 7000, 'Cây', 321, 'Bút lông bảng 1 đầu có nét viết có màu ổn định trong suốt quá trình sử dụng, lưu trữ, bảo quản.'),
(14, 1, 6, 'Bút bi Thiên Long TL-027', 4500, 'Cây', 1836, 'Bút bi Thiên Long 027 là một trong những sản phẩm bút được bán với số lượng nhiều nhất của hãng Thiên Long, quen thuộc với hầu hết tất cả mọi người'),
(15, 1, 6, 'Bút bi Thiên Long TL-079', 4500, 'Cây', 752, 'Bút bi Thiên Long 029 là dạng bút bi bấm, vỏ bút bằng chất liệu nhựa cứng, loại bút với đầu bi 0.5mm - nét chữ mảnh, uyển chuyển'),
(16, 1, 5, 'Bút chì chuốt Gstar P333 4B', 2500, 'Cây', 4132, 'Thân chì xanh, có thiết kế phần cuối bút có gôm, bút chì chuốt nhọn 1 đầu, khi sử dụng qua một thời gian cần sử dụng gọt chì'),
(17, 1, 5, 'Bút chì chuốt Gstar 3B', 2000, 'Cây', 900, 'Thuộc loại bút chì 3B - có độ đậm và đô cứng vừa phải, rất thông dụng trên thị trường'),
(18, 3, 12, 'Gôm Pentel H.05', 8500, 'Cái', 512, 'Màu trắng, chất liệu cao cấp, tẩy sạch nét chì trên giấy không để lại vết ố, hoặc làm rách giấy.'),
(19, 3, 12, 'Chuốt chì 01 lỗ hình chữ nhật', 10000, 'Cái', 270, 'Chuốt 01 lỗ, thân vỏ nhựa với lưỡi thép chuyên dụng'),
(20, 5, 10, 'Băng keo trong 5F', 50000, 'Cuộn', 200, 'Băng Keo Trong 5F là sản phẩm băng keo được làm từ chất liệu OPP được sử dụng rộng rãi và thông dụng trên thị trường hiện nay'),
(21, 2, 7, 'Atlat Địa lý Việt Nam', 25000, 'Cuốn', 150, 'Atlat Địa lí Việt Nam là một tập bản đồ được sắp xếp theo thứ tự: Địa lí tự nhiên, địa lí dân cư,...'),
(22, 2, 7, 'Bộ sách giáo khoa lớp 1', 190000, 'Bộ', 300, 'Sách giáo khoa là một loại sách đặc thù cung cấp kiến thức mang tính nền tảng cho người học'),
(23, 6, 6, 'Keo khô Thiên Long G-019', 5000, 'Chai', 600, 'Keo khô Thiên Long G-019 là loại keo chuyên dùng để dán giấy, ở dạng khô, sử dụng thuận tiện, không lo bị chảy, không bám dính tay'),
(24, 6, 6, 'Keo dán giấy Điểm 10 G-08', 4000, 'Chai', 532, 'Keo dán giấy Thiên Long - Điểm 10 G-08 là dạng keo lỏng, lọ nhỏ dung tích 30ml tiện dụng, mùi dễ chịu, không gắt'),
(25, 7, 11, 'Máy tính Casio fx-580VN X', 750000, 'Cái', 100, 'Máy được trang bị màn hình LCD có độ phân giải cao. Casio fx-580VN X là bước tiến đột phá, mang công nghệ đến gần hơn với lớp học.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitietdondathang`
--
ALTER TABLE `chitietdondathang`
  ADD KEY `FK_ChiTietDonDatHang_DonDatHang` (`MaDH`);

--
-- Indexes for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD KEY `FK_ChiTietHoaDon_HoaDon` (`MaHD`),
  ADD KEY `FK_ChiTietHoaDon_SanPham` (`MaSP`);

--
-- Indexes for table `chucvu`
--
ALTER TABLE `chucvu`
  ADD PRIMARY KEY (`MaCV`);

--
-- Indexes for table `dondathang`
--
ALTER TABLE `dondathang`
  ADD PRIMARY KEY (`MaDDH`);

--
-- Indexes for table `hinhanh`
--
ALTER TABLE `hinhanh`
  ADD KEY `FK_HinhAnh_SanPham` (`MaSP`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHD`),
  ADD KEY `FK_HoaDon_NhanVien` (`MaNV`),
  ADD KEY `FK_HoaDon_KhuyenMai` (`MaKM`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`);

--
-- Indexes for table `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`MaKM`);

--
-- Indexes for table `loaisp`
--
ALTER TABLE `loaisp`
  ADD PRIMARY KEY (`MaLoai`);

--
-- Indexes for table `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`),
  ADD UNIQUE KEY `TenDangNhap` (`TenDangNhap`),
  ADD KEY `FK_NhanVien_ChucVu` (`MaCV`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `FK_SanPham_LoaiSP` (`MaLoai`),
  ADD KEY `FK_SanPham_NhaCungCap` (`MaNCC`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chucvu`
--
ALTER TABLE `chucvu`
  MODIFY `MaCV` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dondathang`
--
ALTER TABLE `dondathang`
  MODIFY `MaDDH` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `MaHD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `MaKM` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `loaisp`
--
ALTER TABLE `loaisp`
  MODIFY `MaLoai` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `MaNCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietdondathang`
--
ALTER TABLE `chitietdondathang`
  ADD CONSTRAINT `FK_ChiTietDonDatHang_DonDatHang` FOREIGN KEY (`MaDH`) REFERENCES `dondathang` (`MaDDH`);

--
-- Constraints for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `FK_ChiTietHoaDon_HoaDon` FOREIGN KEY (`MaHD`) REFERENCES `hoadon` (`MaHD`),
  ADD CONSTRAINT `FK_ChiTietHoaDon_SanPham` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Constraints for table `hinhanh`
--
ALTER TABLE `hinhanh`
  ADD CONSTRAINT `FK_HinhAnh_SanPham` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `FK_HoaDon_KhuyenMai` FOREIGN KEY (`MaKM`) REFERENCES `khuyenmai` (`MaKM`),
  ADD CONSTRAINT `FK_HoaDon_NhanVien` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `FK_NhanVien_ChucVu` FOREIGN KEY (`MaCV`) REFERENCES `chucvu` (`MaCV`);

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `FK_SanPham_LoaiSP` FOREIGN KEY (`MaLoai`) REFERENCES `loaisp` (`MaLoai`),
  ADD CONSTRAINT `FK_SanPham_NhaCungCap` FOREIGN KEY (`MaNCC`) REFERENCES `nhacungcap` (`MaNCC`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
