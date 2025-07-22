<!-- display success message  from sms_sender.php -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?php
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        ?>
    </div>
<?php endif; ?>

<section id="send-sms" class="content-section">
            <div class="content-header">
                <h1>Send Bulk SMS</h1>
                <p>Send messages to multiple recipients at once.</p>
            </div>

            <div class="info-box">
                <p><strong>Important:</strong> Enter phone numbers in international format. For Kenya, use format like: <code>254712345678</code>, <code>254798765432</code>. No plus sign (+).</p>
            </div>

            <form method="POST" action="sms_sender.php">
                <div class="form-group">
                    <label for="recipients">Recipients (Comma-separated phone numbers):</label>
                    <textarea id="recipients" name="recipients" rows="4" placeholder="e.g. 254712345678, 254798765432" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" placeholder="Type your message here..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="schedule">Schedule (Optional):</label>
                    <input type="datetime-local" id="schedule" name="schedule">
                </div>

                <button type="submit" class="btn btn-primary">Send Bulk SMS</button>
            </form>
        </section>

