# 🍽️ Catering Booking System - Docker Setup

## 📋 Prerequisites

Before starting, make sure you have:
- **Docker Desktop** installed and running
- **Git** (for cloning the repository)
- **Stop XAMPP** if it's running (to avoid port conflicts)

## 🚀 Step-by-Step Setup

### Step 1: Get the Project

```powershell
# Clone the repository
git clone <your-repository-url>
cd catering-booking

# OR if you already have the files, just open PowerShell in the project folder
```

### Step 2: Install Docker Desktop

1. Download from: <https://www.docker.com/products/docker-desktop/>
2. Install and restart your computer
3. Make sure Docker Desktop is running (check system tray)

### Step 3: Stop XAMPP (Important!)

- Open XAMPP Control Panel
- Stop **Apache** and **MySQL** services
- This prevents port conflicts

### Step 4: Start the Application

```powershell
# In the project directory, run:
docker-compose up -d
```

**Expected output:**

```
[+] Running 4/4
 ✔ Network catering-booking_default         Created
 ✔ Container catering-booking-db-1          Started
 ✔ Container catering-booking-phpmyadmin-1  Started
 ✔ Container catering-booking-web-1         Started
```

### Step 5: Access the Application

- **🌐 Website**: <http://localhost:8080>
- **🗄️ Database Management**: <http://localhost:8081>
  - Username: `root`
  - Password: `rootpassword`

## ✅ Verification

### Check if everything is working:

1. **Website**: Go to <http://localhost:8080> - you should see the catering booking homepage
2. **Database**: Go to <http://localhost:8081> - you should see phpMyAdmin with `catering_booking` database
3. **Tables**: In phpMyAdmin, check that tables like `admin`, `message`, `orders` are present

## 🛠️ Common Commands

### Stop the application:

```powershell
docker-compose down
```

### Start the application:

```powershell
docker-compose up -d
```

### View logs (if something goes wrong):

```powershell
docker-compose logs
```

### Rebuild containers (if you change Dockerfile):

```powershell
docker-compose down
docker-compose up -d --build
```

## 🚨 Troubleshooting

### Error: "Port already in use"

**Problem**: XAMPP or another service is using the ports
**Solution**:
1. Stop XAMPP completely
2. Run: `docker-compose down`
3. Run: `docker-compose up -d`

### Error: "Cannot connect to database"

**Problem**: Database container not ready
**Solution**:
1. Wait 30 seconds for MySQL to start
2. Check logs: `docker-compose logs db`
3. Restart: `docker-compose restart`

### Website shows "Forbidden"

**Problem**: This should not happen with current setup
**Solution**:
1. Go to <http://localhost:8080/Project/> directly
2. Check containers are running: `docker-compose ps`

### Database not imported

**Problem**: `cateringdata.sql` not loaded
**Solution**:
1. Stop containers: `docker-compose down`
2. Remove volumes: `docker volume rm catering-booking_db_data`
3. Start again: `docker-compose up -d`

## 📊 Database Connection Details

For your PHP code, the database connection uses:
- **Host**: `db` (Docker internal network)
- **Database**: `catering_booking`
- **Username**: `root`
- **Password**: `rootpassword`
- **Port**: `3306` (internal), `3307` (external)

## 🔄 For Development

- **Live reload**: Your code changes are reflected immediately
- **Database persistence**: Data survives container restarts
- **No XAMPP needed**: Everything runs in Docker

## 💳 ToyyibPay Payment Gateway Setup

To securely set up the ToyyibPay payment gateway:

1. **Create a Configuration File**:
   - There is a template file called `toyyibpay_config.example.php` in the Project folder
   - Create a copy of this file and rename it to `toyyibpay_config.php`
   - Edit your `toyyibpay_config.php` file with your actual ToyyibPay credentials

2. **Required Credentials**:
   - `TOYYIBPAY_USER_SECRET_KEY`: Your secret key from ToyyibPay dashboard
   - `TOYYIBPAY_CATEGORY_CODE`: The category code for your payments

3. **Security Measures**:
   - The `toyyibpay_config.php` file is automatically ignored by git (added to `.gitignore`)
   - **IMPORTANT**: Never commit your actual credentials to the repository
   - Each developer needs their own local copy with their own credentials

4. **For Testing**:
   - ToyyibPay provides sandbox credentials for testing
   - Use sandbox credentials during development
   - Switch to production credentials only for deployment

## 👥 Team Collaboration

Each team member just needs to:

1. Install Docker Desktop
2. Clone this repository
3. **Set up ToyyibPay Configuration** (refer to the ToyyibPay section above):
   - Copy `Project/toyyibpay_config.example.php` to `Project/toyyibpay_config.php`
   - Update with your credentials (never commit this file)
4. Run `docker-compose up -d`
5. Access the application at <http://localhost:8080>

**No more "it works on my machine" problems!** 🎉

## 📞 Need Help?

If you encounter issues:

1. Check this troubleshooting section
2. Share the error message with the team
3. Run `docker-compose logs` to see detailed logs

---

## 📁 Project Structure

```
catering-booking/
├── Project/               # Main application files
│   ├── index.php         # Homepage
│   ├── login.php         # Login page
│   ├── menu.php          # Menu page
│   └── includes/         # CSS, JS, and images
├── docker-compose.yml    # Docker configuration
├── Dockerfile           # PHP/Apache setup
└── cateringdata.sql     # Database schema
```

## Prerequisites

- Install Docker Desktop for Windows from <https://www.docker.com/products/docker-desktop/>
- Make sure Docker Desktop is running

## Setup Instructions

### 1. First Time Setup

Open PowerShell in your project directory and run:

```powershell
# Build and start all containers
docker-compose up -d

# Check if containers are running
docker-compose ps
```

### 2. Access Your Application

- **Website**: <http://localhost:8080>
- **phpMyAdmin**: <http://localhost:8081>
  - Username: `root`
  - Password: `rootpassword`

### 3. Database Setup

The `cateringdata.sql` file will be automatically imported when you first start the containers.

### 4. Development Workflow

- Make changes to your PHP files
- Changes will be reflected immediately (no need to restart containers)
- Database data persists between container restarts

### 5. Useful Commands

```powershell
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs

# Restart containers
docker-compose restart

# Remove containers and data (careful!)
docker-compose down -v
```



