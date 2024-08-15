<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Service\client\CartService;
use Illuminate\Support\Facades\Log;

class MailService
{
    private $mail;
    private $cartService;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = config('mail.mailers.smtp.host');
        $this->mail->SMTPAuth = true;
        $this->mail->Username = config('mail.mailers.smtp.username');
        $this->mail->Password = config('mail.mailers.smtp.password');
        $this->mail->SMTPSecure = config('mail.mailers.smtp.encryption');
        $this->mail->Port = config('mail.mailers.smtp.port');
        $this->mail->setFrom(config('mail.mailers.smtp.username'), 'Mouse Shop');
        $this->cartService = new CartService();

        // dd(config('mail.mailers.smtp.host'));
    }

    public function adminSend($to, $name, $orderId, $email, $phone, $address, $payment, $delivery, $createAt, $discount, $total)
    {
        try {
            Log::info('Start sending mail to admin! address: ' . $to . ', orderId: ' . $orderId);
            $this->mail->addAddress($to);

            $createAt = date('d/m/Y H:i:s', strtotime($createAt));
            $discount = $discount ? $discount : 0;
            $subject = '=?UTF-8?B?' . base64_encode('Announcement of new order number #' . $orderId . ' from Mouse Shop') . '?=';

            if ($delivery == '1') {
                $delivery = 'Economical delivery';
            } elseif ($delivery == '2') {
                $delivery = 'Express delivery';
            } else {
                $delivery = 'Pick up at the store';
            }
            if ($payment == '1') {
                $payment = 'Pay at store';
            } elseif ($payment == '2') {
                $payment = 'Cash on Delivery (COD)';
            } else {
                $payment = 'Bank transfer';
            }

            $products = $this->cartService->getCart();
            $productHtml = '';
            foreach ($products as $product) {
                $this->mail->AddEmbeddedImage(public_path($product->productDetail->product->img), 'image_' . $product->productDetail->product->id);
                $productHtml .= '
                <li>
                    <table style="width: 100%; border-bottom: 1px solid rgb(228, 233, 235);">
                        <tbody>
                            <tr>
                                <td style="width: 100%; padding: 25px 10px 0px 0" colspan="2">
                                    <div style="float: left; width: 80px; height: 80px; border: 1px solid rgb(235, 239, 242); overflow: hidden; ">
                                        <img style=" max-width: 100%; max-height: 100%;" src="' . 'cid:image_' . $product->productDetail->product->id . '" />
                                    </div>
                                    <div style="margin-left: 100px">
                                        <a href=" ' . config('app.url') . '/shop/product/' . $product->productDetail->product->id . ' " style="color: rgb(169, 0, 0); text-decoration: none;" target="_blank" data-saferedirecturl="test">
                                            ' . $product->productDetail->product->name . '</a>
                                        <p style="color: rgb(103, 130, 153); margin-bottom: 0px; margin-top: 8px;">
                                            ' . $product->productDetail->product->name . '
                                        </p>
                                        <p>
                                        size: ' . $product->productDetail->size->name . ' - color: ' . $product->productDetail->color->name . '
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 70%; padding: 5px 0px 25px">
                                    <div style="margin-left: 100px">
                                        ¥' . $product->price . '
                                        <span style="margin-left: 20px">x' . $product->quantity . '</span>
                                    </div>
                                </td>
                                <td style="text-align: right; width: 30%; padding: 5px 0px 25px;">
                                    ¥' . $product->price * $product->quantity  . '
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            ';
            }

            $mailTemplate = '
                <div style="padding: 0 10px; margin-bottom: 25px">
                    <div>
                        <p>New order notification at <strong>Mouse shop</strong>!</p>
                        <p>Order number <span style="color: rgb(169, 0, 0)">#' . $orderId . '</span> is waiting for your confirm.</p>
                    </div>
                    <hr />
                    <div style="padding: 0 10px">
                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px">
                            <thead>
                                <tr>
                                    <th style="text-align: left; width: 50%; font-size: medium; padding: 5px 0;">Customer information</th>
                                    <th style="text-align: left; width: 50%; font-size: medium; padding: 5px 0;">Delivery address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding-right: 15px">
                                        <table style="width: 100%">
                                            <tbody>
                                                <tr><td>' . $name . '</td></tr>
                                                <tr>
                                                    <td style="word-break: break-word; word-wrap: break-word;">
                                                        <a href="mailto:' . $email . '" target="_blank">' . $email . '</a>
                                                    </td>
                                                </tr>
                                                <tr><td>' . $phone . '</td></tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="width: 100%">
                                            <tbody>
                                                <tr><td>' . $name . '</td></tr>
                                                <tr><td style="word-break: break-word; word-wrap: break-word;">' . $address . '</td></tr>
                                                <tr><td>' . $phone . '</td></tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px">
                            <thead>
                                <tr>
                                    <th style="text-align: left; width: 50%; font-size: medium; padding: 5px 0;">Payment method</th>
                                    <th style="text-align: left; width: 50%; font-size: medium; padding: 5px 0;">Delivery method</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding-right: 15px">' . $payment . '</td>
                                    <td>' . $delivery . '<br /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 20px; padding: 0 10px">
                        <div style="padding-top: 10px; font-size: medium">
                            <strong>Order information</strong>
                        </div>
                        <table style="width: 100%; margin: 10px 0">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; padding-right: 15px">
                                        Order Id: #' . $orderId . '
                                    </td>
                                    <td style="width: 50%">Order create at: <strong>' . $createAt . '</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <ul style="padding-left: 0; list-style-type: none; margin-bottom: 0">
                            ' . $productHtml . '
                        </ul>
                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 50px; margin-top: 10px;">
                            <tbody>
                                <tr>
                                    <td style="width: 20%"></td>
                                    <td style="width: 80%">
                                        <table style="width: 100%; float: right">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-bottom: 10px">Promotion:</td>
                                                    <td style="font-weight: bold; text-align: right; padding-bottom: 10px;">¥' . $discount . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 10px">Shipping fee:</td>
                                                    <td style="font-weight: bold; text-align: right; padding-bottom: 10px;">¥0</td>
                                                </tr>
                                                <tr style="border-top: 1px solid rgb(229, 233, 236);">
                                                    <td style="padding-top: 10px">Total:</td>
                                                    <td style="font-weight: bold; text-align: right; font-size: 16px; padding-top: 10px;">¥' . $total . '</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <div style="padding: 0 10px">
                    <div style="clear: both"></div>
                    <p style="text-align: right"><i>Best regards,</i></p>
                    <p style="text-align: right">
                        <strong>Automatic management system Mouse shop</strong>
                    </p>
                </div>
            </div>';

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $mailTemplate;
            $this->mail->send();
            $this->mail->clearAddresses();
            $this->mail->clearAttachments();
            $this->mail->ClearCCs();
            $this->mail->ClearBCCs();
            $this->mail->clearReplyTos();
            $this->mail->Subject = '';
            $this->mail->Body = '';
            Log::info('Successful sent mail to admin! address: ' . $to . ', orderId: ' . $orderId);
        } catch (Exception $e) {
            Log::error('Failed to send mail to admin! address: ' . $to . ', orderId: ' . $orderId);
            Log::error("Mailer Error: {$this->mail->ErrorInfo}");
        }
    }

    public function customerSend($to, $name, $orderId, $email, $phone, $address, $payment, $delivery, $createAt, $discount, $total)
    {
        try {
            Log::info('Start sending mail to customer! address: ' . $to . ', orderId: ' . $orderId);
            $this->mail->addAddress($to);

            $createAt = date('d/m/Y H:i:s', strtotime($createAt));
            $discount = $discount ? $discount : 0;
            $subject = '=?UTF-8?B?' . base64_encode('Confirmation of successful order number #' . $orderId . ' from Mouse Shop') . '?=';

            if ($delivery == '1') {
                $delivery = 'Economical delivery';
            } elseif ($delivery == '2') {
                $delivery = 'Express delivery';
            } else {
                $delivery = 'Pick up at the store';
            }
            if ($payment == '1') {
                $payment = 'Pay at store';
            } elseif ($payment == '2') {
                $payment = 'Cash on Delivery (COD)';
            } else {
                $payment = 'Bank transfer';
            }

            $products = $this->cartService->getCart();
            $productHtml = '';
            foreach ($products as $product) {
                $this->mail->AddEmbeddedImage(public_path($product->productDetail->product->img), 'image_' . $product->productDetail->product->id);
                $productHtml .= '
                <li>
                    <table style="width: 100%; border-bottom: 1px solid rgb(228, 233, 235);">
                        <tbody>
                            <tr>
                                <td style="width: 100%; padding: 25px 10px 0px 0" colspan="2">
                                    <div style="float: left; width: 80px; height: 80px; border: 1px solid rgb(235, 239, 242); overflow: hidden; ">
                                        <img style=" max-width: 100%; max-height: 100%;" src="' . 'cid:image_' . $product->productDetail->product->id . '" />
                                    </div>
                                    <div style="margin-left: 100px">
                                        <a href=" ' . config('app.url') . '/shop/product/' . $product->productDetail->product->id . ' " style="color: rgb(169, 0, 0); text-decoration: none;" target="_blank" data-saferedirecturl="test">
                                            ' . $product->productDetail->product->name . '</a>
                                        <p style="color: rgb(103, 130, 153); margin-bottom: 0px; margin-top: 8px;">
                                            ' . $product->productDetail->product->name . '
                                        </p>
                                        <p>
                                        size: ' . $product->productDetail->size->name . ' - color: ' . $product->productDetail->color->name . '
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 70%; padding: 5px 0px 25px">
                                    <div style="margin-left: 100px">
                                        ¥' . $product->price . '
                                        <span style="margin-left: 20px">x' . $product->quantity . '</span>
                                    </div>
                                </td>
                                <td style="text-align: right; width: 30%; padding: 5px 0px 25px;">
                                    ¥' . $product->price * $product->quantity  . '
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            ';
            }

            $mailTemplate = '
                <div style="padding: 0 10px; margin-bottom: 25px">
                    <div>
                        <p>Hello ' . $name . '</p>
                        <p>Thank you for ordering at <strong>Mouse shop</strong>!</p>
                        <p>Your order number <span style="color: rgb(169, 0, 0)">#' . $orderId . '</span> has been confirmed by the system, we will contact you as soon as possible</p>
                        <p><strong>This is an automated system, please do not reply to this email</strong></p>
                    </div>
                    <hr />
                    <div style="padding: 0 10px">
                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px">
                            <thead>
                                <tr>
                                    <th style="text-align: left; width: 50%; font-size: medium; padding: 5px 0;">Customer information</th>
                                    <th style="text-align: left; width: 50%; font-size: medium; padding: 5px 0;">Delivery address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding-right: 15px">
                                        <table style="width: 100%">
                                            <tbody>
                                                <tr><td>' . $name . '</td></tr>
                                                <tr>
                                                    <td style="word-break: break-word; word-wrap: break-word;">
                                                        <a href="mailto:' . $email . '" target="_blank">' . $email . '</a>
                                                    </td>
                                                </tr>
                                                <tr><td>' . $phone . '</td></tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="width: 100%">
                                            <tbody>
                                                <tr><td>' . $name . '</td></tr>
                                                <tr><td style="word-break: break-word; word-wrap: break-word;">' . $address . '</td></tr>
                                                <tr><td>' . $phone . '</td></tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px">
                            <thead>
                                <tr>
                                    <th style="text-align: left; width: 50%; font-size: medium; padding: 5px 0;">Payment method</th>
                                    <th style="text-align: left; width: 50%; font-size: medium; padding: 5px 0;">Delivery method</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding-right: 15px">' . $payment . '</td>
                                    <td>' . $delivery . '<br /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 20px; padding: 0 10px">
                        <div style="padding-top: 10px; font-size: medium">
                            <strong>Order information</strong>
                        </div>
                        <table style="width: 100%; margin: 10px 0">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; padding-right: 15px">
                                        Order Id: #' . $orderId . '
                                    </td>
                                    <td style="width: 50%">Order create at: <strong>' . $createAt . '</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <ul style="padding-left: 0; list-style-type: none; margin-bottom: 0">
                            ' . $productHtml . '
                        </ul>
                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 50px; margin-top: 10px;">
                            <tbody>
                                <tr>
                                    <td style="width: 20%"></td>
                                    <td style="width: 80%">
                                        <table style="width: 100%; float: right">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-bottom: 10px">Promotion:</td>
                                                    <td style="font-weight: bold; text-align: right; padding-bottom: 10px;">¥' . $discount . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 10px">Shipping fee:</td>
                                                    <td style="font-weight: bold; text-align: right; padding-bottom: 10px;">¥0</td>
                                                </tr>
                                                <tr style="border-top: 1px solid rgb(229, 233, 236);">
                                                    <td style="padding-top: 10px">Total:</td>
                                                    <td style="font-weight: bold; text-align: right; font-size: 16px; padding-top: 10px;">¥' . $total . '</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <div style="padding: 0 10px">
                    <div style="clear: both"></div>
                    <p style="text-align: right"><i>Best regards,</i></p>
                    <p style="text-align: right">
                        <strong>Automatic management system Mouse shop</strong>
                    </p>
                </div>
            </div>';

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $mailTemplate;
            $this->mail->send();
            $this->mail->clearAddresses();
            $this->mail->clearAttachments();
            $this->mail->ClearCCs();
            $this->mail->ClearBCCs();
            $this->mail->clearReplyTos();
            $this->mail->Subject = '';
            $this->mail->Body = '';
            Log::info('Successful sent mail to customer! address: ' . $to . ', orderId: ' . $orderId);
        } catch (Exception $e) {
            Log::error('Failed to send mail to customer! address: ' . $to . ', orderId: ' . $orderId);
            Log::error("Mailer Error: {$this->mail->ErrorInfo}");
        }
    }
}
