<?php 
require_once "./core/DbManager.php";

try {
    $dbManager = new DbManager();
    $pdo = $dbManager->getConnection();
    
    // セッションからユーザーIDを取得
    $userId = Session::getUserId();
    
    // デバッグ用：ユーザーIDが取得できているか確認
    if (!$userId) {
        throw new Exception("ユーザーIDが取得できません。ログインしてください。");
    }
    
    // 購入情報を取得（最新順）
    // 修正点：列名の重複を削除、ピリオドをカンマに修正
    $stmt = $pdo->prepare('SELECT PRODUCT, PRICE, AMOUNT, TOTAL, DATE FROM user_purchases WHERE user_id = :user_id ORDER BY date DESC');
    $stmt->execute([':user_id' => $userId]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // デバッグ用：取得したデータの構造を確認
    if (!empty($orders)) {
        $sampleOrder = $orders[0];
        $availableColumns = array_keys($sampleOrder);
    } else {
        // データがない場合のデバッグ情報
        $debugStmt = $pdo->prepare('SELECT COUNT(*) as count FROM user_purchases WHERE user_id = :user_id');
        $debugStmt->execute([':user_id' => $userId]);
        $debugResult = $debugStmt->fetch(PDO::FETCH_ASSOC);
        $debugMessage = "ユーザーID {$userId} の購入履歴件数: " . $debugResult['count'];
    }
    
} catch (PDOException $e) {
    $errorMessage = "データベースエラー: " . $e->getMessage();
} catch (Exception $e) {
    $errorMessage = "エラー: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文履歴</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .order-item {
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 5px;
            background-color: #fafafa;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .order-date {
            color: #666;
            font-size: 14px;
        }
        .order-total {
            color: #007bff;
            font-size: 18px;
        }
        .order-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }
        .detail-item {
            background-color: white;
            padding: 8px;
            border-radius: 3px;
            border-left: 3px solid #007bff;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
            font-size: 12px;
            text-transform: uppercase;
        }
        .detail-value {
            margin-top: 2px;
        }
        .no-orders {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }
        .debug-info {
            background-color: #e7f3ff; 
            padding: 10px; 
            margin-bottom: 20px; 
            border-radius: 5px; 
            font-size: 12px;
        }
        .error-message {
            background-color: #f8d7da; 
            color: #721c24; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>購入履歴一覧</h1>
        
        <?php if (isset($errorMessage)): ?>
            <div class="error-message">
                <?= htmlspecialchars($errorMessage) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($debugMessage)): ?>
            <div class="debug-info">
                <strong>デバッグ情報:</strong> <?= htmlspecialchars($debugMessage) ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($orders) && !isset($errorMessage)): ?>
            <div class="no-orders">
                購入履歴がありません。
            </div>
        <?php elseif (!empty($orders)): ?>
            <!-- デバッグ用：利用可能なカラム表示 -->
            <div class="debug-info">
                <strong>データベースのカラム:</strong> <?= implode(', ', $availableColumns) ?>
            </div>
            
            <div style="margin-bottom: 20px;">
                <strong>総件数:</strong> <?= count($orders) ?>件
            </div>
            
            <?php foreach ($orders as $index => $order): ?>
                <div class="order-item">
                    <div class="order-header">
                        <div>
                            <strong>購入記録 #<?= $index + 1 ?></strong>
                            <?php if (isset($order['id'])): ?>
                                <span style="color: #666;"> (ID: <?= htmlspecialchars($order['id']) ?>)</span>
                            <?php endif; ?>
                            
                            <?php if (isset($order['date'])): ?>
                                <div class="order-date">
                                    <?= date('Y年m月d日 H:i', strtotime($order['date'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (isset($order['total']) || isset($order['amount']) || isset($order['price'])): ?>
                        <div class="order-total">
                            ¥<?= number_format($order['total'] ?? $order['amount'] ?? $order['price'] ?? 0) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="order-details">
                        <?php foreach ($order as $key => $value): ?>
                            <?php if ($value !== null && $value !== ''): ?>
                                <div class="detail-item">
                                    <div class="detail-label"><?= htmlspecialchars($key) ?></div>
                                    <div class="detail-value">
                                        <?php if (in_array($key, ['date', 'created_at', 'updated_at'])): ?>
                                            <?= date('Y-m-d H:i:s', strtotime($value)) ?>
                                        <?php elseif (in_array($key, ['amount', 'price', 'total_amount', 'total'])): ?>
                                            ¥<?= number_format($value) ?>
                                        <?php else: ?>
                                            <?= htmlspecialchars($value) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>