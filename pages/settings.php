<?php
require_once '../includes/db_connect.php';
require_once '../includes/session.php';
requireLogin();

$user_id = getUserId();

$pageTitle = 'Settings - HOOSHungry';
$currentPage = 'settings';

ob_start();
?>

<div class="page-header">
    <h1>Settings</h1>
    <p>Manage your application preferences</p>
</div>

<div class="profile-card" style="max-width: 800px;">
    <h2>Application Settings</h2>
    <p style="color: #666; margin-bottom: 30px;">Configure how the application works for you</p>
    
    <div style="margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #e0e0e0;">
        <h3 style="font-size: 18px; margin-bottom: 15px;">General Settings</h3>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
            <div>
                <strong>Default Serving Size</strong>
                <p style="color: #666; font-size: 13px;">Set the default number of servings for new recipes</p>
            </div>
            <select style="padding: 8px 15px; border: 2px solid #e0e0e0; border-radius: 6px;">
                <option value="2">2 servings</option>
                <option value="4" selected>4 servings</option>
                <option value="6">6 servings</option>
                <option value="8">8 servings</option>
            </select>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
            <div>
                <strong>Measurement Units</strong>
                <p style="color: #666; font-size: 13px;">Choose your preferred measurement system</p>
            </div>
            <select style="padding: 8px 15px; border: 2px solid #e0e0e0; border-radius: 6px;">
                <option value="imperial" selected>Imperial (cups, tbsp, oz)</option>
                <option value="metric">Metric (ml, g, kg)</option>
            </select>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
            <div>
                <strong>Date Format</strong>
                <p style="color: #666; font-size: 13px;">How dates should be displayed</p>
            </div>
            <select style="padding: 8px 15px; border: 2px solid #e0e0e0; border-radius: 6px;">
                <option value="mdy" selected>MM/DD/YYYY</option>
                <option value="dmy">DD/MM/YYYY</option>
                <option value="ymd">YYYY-MM-DD</option>
            </select>
        </div>
    </div>
    
    <div style="margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #e0e0e0;">
        <h3 style="font-size: 18px; margin-bottom: 15px;">Privacy & Security</h3>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
            <div>
                <strong>Profile Visibility</strong>
                <p style="color: #666; font-size: 13px;">Control who can see your recipes</p>
            </div>
            <label style="position: relative; display: inline-block; width: 50px; height: 24px;">
                <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #667eea; transition: .4s; border-radius: 24px;"></span>
            </label>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
            <div>
                <strong>Two-Factor Authentication</strong>
                <p style="color: #666; font-size: 13px;">Add an extra layer of security</p>
            </div>
            <button class="btn btn-secondary" style="padding: 8px 20px;" onclick="alert('Two-factor authentication setup coming soon!')">Enable</button>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
            <div>
                <strong>Change Password</strong>
                <p style="color: #666; font-size: 13px;">Update your account password</p>
            </div>
            <button class="btn btn-secondary" style="padding: 8px 20px;" onclick="alert('Change password feature coming soon!')">Update</button>
        </div>
    </div>
    
    <div style="margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #e0e0e0;">
        <h3 style="font-size: 18px; margin-bottom: 15px;">Notifications</h3>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
            <div>
                <strong>Email Notifications</strong>
                <p style="color: #666; font-size: 13px;">Receive meal planning reminders via email</p>
            </div>
            <label style="position: relative; display: inline-block; width: 50px; height: 24px;">
                <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #667eea; transition: .4s; border-radius: 24px;"></span>
            </label>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
            <div>
                <strong>Weekly Summary</strong>
                <p style="color: #666; font-size: 13px;">Get a weekly summary of your cooking activity</p>
            </div>
            <label style="position: relative; display: inline-block; width: 50px; height: 24px;">
                <input type="checkbox" style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px;"></span>
            </label>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
            <div>
                <strong>Recipe Suggestions</strong>
                <p style="color: #666; font-size: 13px;">Receive personalized recipe recommendations</p>
            </div>
            <label style="position: relative; display: inline-block; width: 50px; height: 24px;">
                <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #667eea; transition: .4s; border-radius: 24px;"></span>
            </label>
        </div>
    </div>
    
    <div>
        <h3 style="font-size: 18px; margin-bottom: 15px; color: #dc3545;">Danger Zone</h3>
        
        <div style="padding: 20px; background: #fff5f5; border: 2px solid #dc3545; border-radius: 8px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="color: #dc3545;">Delete Account</strong>
                    <p style="color: #666; font-size: 13px; margin-top: 5px;">Permanently delete your account and all data</p>
                </div>
                <button class="btn-danger" style="padding: 10px 20px; border-radius: 6px; cursor: pointer;" onclick="if(confirm('Are you sure? This action cannot be undone!')) alert('Delete account feature coming soon!')">Delete Account</button>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 30px;">
        <button class="btn btn-primary" onclick="alert('Settings saved!')">Save Settings</button>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../includes/layout.php';
?>