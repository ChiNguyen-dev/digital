<div class="box-mail">
    <div style="background-color:#ffffff;">
        <div style="background-color:#ffffff;color:#000000;">
            <div style="margin:0 auto;width:600px;">
                <div style="padding:30px 20px;">
                    <table align="center" bgcolor="#dcf0f8" cellpadding="0"
                           style="border: 0; margin:0;padding:0;background-color:#ffffff;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                        <tbody>
                        <tr>
                            <td>
                                <h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0;">
                                    Cảm ơn quý khách {{ $user->name }} đã đặt hàng tại Digital,
                                </h1>

                                <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;">
                                    Digital rất vui thông báo đơn hàng #{{ $order->id }} của quý khách đã được tiếp nhận
                                    và
                                    đang trong quá trình xử lý. Digital sẽ thông báo đến quý khách ngay khi hàng chuẩn
                                    bị được giao.</p>

                                <h3 style="font-size:13px;font-weight:bold;color:#5a4bde;text-transform:uppercase;margin:20px 0 0 0;
                                border-bottom:1px solid #ddd;">
                                    Thông tin đơn hàng #{{ $order->id }}
                                    <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal;">(Ngày 30 Tháng 01 Năm 2023 09:09:15)</span>
                                </h3>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;">
                                <table style="border: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th style="width: 50%; text-align: left; padding:6px 9px 0 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold">
                                            Thông tin thanh toán
                                        </th>
                                        <th style="width: 50%; text-align: left; padding:6px 9px 0 9px;font-family:Arial,Helvetica,sans-serif;
                                        font-size:12px;color:#444;font-weight:bold;">
                                            Địa chỉ giao hàng
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td style="padding:3px 9px 9px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;
                                        font-size:12px;color:#444;line-height:18px;font-weight:normal;vertical-align: top;">
                                            <span style="text-transform:capitalize;">{{ $user->name }}</span><br>
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a><br>
                                            {{ $user->phone_number }}
                                        </td>
                                        <td style="padding:3px 9px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;
                                                   font-size:12px;color:#444;line-height:18px;font-weight:normal; vertical-align: top;">
                                            <span style="text-transform:capitalize">{{ $user->name }}</span><br>
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a><br>
                                            {{ $user->address }}
                                            <br>
                                            T: {{ $user->phone_number }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding:7px 9px 0 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;
                                            font-size:12px;color:#444; vertical-align: top;">
                                            <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;">
                                                <strong>Phương thức thanh toán: </strong>
                                                Thanh toán tiền mặt khi nhận hàng<br>
                                                <strong>Thời gian giao hàng dự kiến:</strong>
                                                Dự kiến giao hàng Thứ năm, 02/02<br>
                                                <strong>Phí vận chuyển: </strong> 2.000đ<br>
                                                <strong>Sử dụng bọc sách cao cấp Bookcare: </strong> Không <br>
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                    <i>Lưu ý: Đối với đơn hàng đã được thanh toán trước, nhân viên giao nhận có thể
                                        yêu cầu người nhận hàng cung cấp CMND / giấy phép lái xe để chụp ảnh hoặc
                                        ghi lại thông tin.</i>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h2 style="text-align:left; margin:10px 0;
                                           border-bottom:1px solid #ddd; padding-bottom:5px; font-size:13px; color:#5a4bde;">
                                    CHI TIẾT ĐƠN HÀNG
                                </h2>

                                <table cellpadding="0" cellspacing="0"
                                       style="background:#f5f5f5; border: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th style="text-align: left; padding:6px 9px;background-color:#5a4bde;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            Sản phẩm
                                        </th>
                                        <th style="text-align: left; background-color: #5a4bde; padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            Đơn giá
                                        </th>
                                        <th style="text-align: left; background-color: #5a4bde; padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            Số lượng
                                        </th>
                                        <th style="text-align: left; background-color: #5a4bde; padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            Giảm giá
                                        </th>
                                        <th style="text-align: right; background-color: #5a4bde; padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            Tổng tạm
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody
                                        style="background-color: #eee ;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                    @foreach($cartItems as $cartItem)
                                        <tr>
                                            <td style="padding:3px 9px; vertical-align: top; text-align: left;">
                                                <span>{{ $cartItem->getName() }}</span><br>
                                            </td>
                                            <td style="padding:3px 9px; vertical-align: top; text-align: left;">
                                                <span>{{ number_format($cartItem->getPrice(),0,',','.') }}đ</span>
                                            </td>
                                            <td style="padding:3px 9px; vertical-align: top; text-align: left;">
                                                {{ $cartItem->getQty() }}
                                            </td>
                                            <td style="padding:3px 9px; vertical-align: top; text-align: left;">
                                                <span>0đ</span>
                                            </td>
                                            <td style="padding:3px 9px; vertical-align: top; text-align: right;">
                                                <span>{{ number_format($cartItem->getPrice() * $cartItem->getQty(),0,',','.')  }}đ</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot
                                        style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                    <tr>
                                        <td colspan="4" style="padding:5px 9px; text-align: right;">Tạm tính</td>
                                        <td style="padding:5px 9px; text-align: right;"><span>{{ number_format($subTotal,0,',','.') }}đ</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="padding:5px 9px; text-align: right;">Phí vận chuyển</td>
                                        <td style="padding:5px 9px; text-align: right;"><span>2.000đ</span></td>
                                    </tr>

                                    <tr style="background-color: #eee;">
                                        <td colspan="4" style="padding:7px 9px; text-align: right;">
                                            <strong><big>Tổng giá trị đơn hàng</big> </strong>
                                        </td>
                                        <td style="padding:7px 9px; text-align: right;">
                                            <strong>
                                                <big><span>{{ number_format($subTotal + 2000,0,',','.') }}đ</span></big>
                                            </strong>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div style="margin:auto;">
                                    <a href="#"
                                       style="display:inline-block;text-decoration:none;background-color:#5a4bde !important;
                                       text-align:center;border-radius:3px;color:#fff;padding:5px 10px;font-size:12px;
                                       font-weight:bold; margin: 15px 30px 0 35%;">
                                        Chi tiết đơn hàng tại Digital
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;
                                <a href="#">
                                    <img
                                        src="https://ci3.googleusercontent.com/proxy/hzh2_D8PnxbNuz83P2hqu7idL2qy94GqnqYXp-UQ5xdYKBQGrnUeN5AydFuxmzUSieep9ZdwYRsfbt6zuNF1thYiOgnqMceKMfO7i1EpfFAgpfDdRQqefoOXJCePZ4ryZpUX=s0-d-e1-ft#https://salt.tikicdn.com/ts/upload/5e/82/5c/882d4c145fcc70bd1881b84e8684f8cf.png"
                                        alt="banner" width="100%" class="CToWUd">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;
                                <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                    Trường hợp quý khách có những băn khoăn về đơn hàng, có thể xem thêm mục
                                    <a href="#" title="Các câu hỏi thường gặp"><strong>các câu hỏi thường gặp</strong>.</a>
                                </p>
                                <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;border:1px #5a4bde dashed;padding:5px;list-style-type:none">
                                    Từ ngày 14/2/2015, Digital sẽ không gởi tin nhắn SMS khi đơn hàng của bạn được xác
                                    nhận thành công. Chúng tôi chỉ liên hệ trong trường hợp đơn hàng có thể bị trễ
                                    hoặc không liên hệ giao hàng được.
                                </p>

                                <p style="margin:10px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                    Mọi thắc mắc và góp ý, quý khách vui lòng liên hệ với Digital Care qua
                                    <a href="#">https://hotro.digital.com/hc/vi</a>
                                    . Đội ngũ Digital Care luôn sẵn sàng hỗ trợ bạn.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;<p>Một lần nữa Digital cảm ơn quý khách.</p></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
