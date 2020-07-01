<?php


namespace IPay88\Validator;



use Illuminate\Support\Facades\Validator;
use IPay88\Security\Signature;

class ResponseValidator
{
    /**
     * @param $response
     * @return array
     */
    public function getResponse($response)
    {
        $return = [];

        $return['MerchantCode'] = $response['MerchantCode'];
        $return['PaymentId'] = $response['PaymentId'];
        $return['RefNo'] = $response['RefNo'];
        $return['Amount'] = $response['Amount'];
        $return['Currency'] = $response['Currency'];
        $return['Remark'] = $response['Remark'];
        $return['TransId'] = $response['TransId'];
        $return['AuthCode'] = $response['AuthCode'];
        $return['Status'] = $response['Status'];
        $return['ErrDesc'] = $response['ErrDesc'];
        $return['Signature'] = $response['Signature'];

        return $return;
    }

    public function validateResponse($data, $merchantKey)
    {
        $validator = $this->getValidator($data);

        if($validator->valid()) {
            $status = $data['Status'];
            $amount = preg_replace('/[.,]/', '', $data['Amount']);

            $signed = Signature::generateTransactionSignature(
                $data['RefNo'],
                $amount,
                $data['Currency'],
                $merchantKey,
                $data['MerchantCode']
            );

            if ($status == '1' && $signed == $data['Signature']) {
                echo 'sign ok';
                // response okay $data['RefNo']
            } else {
                echo 'no ok';
                // response failure
            }
        }
    }

    public function backendResponse($data, $merchantKey){
        $echo = 'RECEIVEOK';
        $validator = $this->getValidator($data);


        if($validator->valid()) {
            $status = $data['Status'];
            $amount = preg_replace('/[.,]/', '', $data['Amount']);

            $signed = Signature::generateTransactionSignature(
                $data['RefNo'],
                $amount,
                $data['Currency'],
                $merchantKey,
                $data['MerchantCode']
            );

            if ($status == '1' && $signed === $data['Signature']) {
                //echo 'sign ok';
                exit;
            } else {
                //echo 'payment failed.';
                echo $echo;
                exit;
            }
        }
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidator($data)
    {
        return Validator::make($data, [
            'MerchantCode' => 'required',
            'PaymentId' => 'required',
            'RefNo' => 'required',
            'Amount' => 'required',
            'Currency' => 'required',
            'Signature' => 'required',
            'Status' => 'required',
        ]);
    }
}
