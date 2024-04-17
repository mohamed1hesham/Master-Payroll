<?php

use App\Models\CiInstances;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instances_run_values', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('person_number');
            $table->date('HireDate');
            $table->float('Basic_Salary');
            $table->float('Basic_Salary_worked_days');
            $table->float('Worked_Days_diff');
            $table->float('Accommodation_allowance_fixed');
            $table->float('Nature_of_Work');
            $table->float('Car_Allowance_fixed');
            $table->float('Transportation_allowance_Fix');
            $table->float('Transport_Fix_Non_Taxable');
            $table->float('Transport_Fix_Taxable');
            $table->float('Transportation_Allowance_non_tax_VAR');
            $table->float('Car_allowance_non_taxable');
            $table->float('Fuel_Allowance_non_taxable');
            $table->float('Nature_of_Work_Allow_NTF');
            $table->float('Representation_Allowance_NTF');
            $table->float('Pay_Review_Bulk_Payment');
            $table->float('Overtime');
            $table->float('Amount_OverTime');
            $table->float('Bonus_Tax_Applicable');
            $table->float('Bonus_Non_Tax_Applicable');
            $table->float('Diff_Salaries');
            $table->float('Incentives');
            $table->float('Vacation_encashment');
            $table->float('Notice_period_compensation');
            $table->float('Transport_allowance_Non_Tax');
            $table->float('Vacation_Encashment_Non_Tax');
            $table->float('other_plus');
            $table->float('Travel_to_Sokhna');
            $table->float('Travel_to_Sahel');
            $table->float('Working_days_Additions');
            $table->float('Food_Allowance_Non_Taxable');
            $table->float('Incentives_Non_Taxable');
            $table->float('COLA');
            $table->float('Finance_Statement_Bonus');
            $table->float('Traffic_Violation');
            $table->float('Mobile_Deduction');
            $table->float('Loan');
            $table->float('Deduction_fixed');
            $table->float('Other_Deduction');
            $table->float('social_insurance');
            $table->float('Taxes');
            $table->float('Misconduct');
            $table->float('Non_Working_days');
            $table->float('Absence_1_25');
            $table->float('Absence_1_50');
            $table->float('Absence_2');
            $table->float('Absence_3');
            $table->float('Absence_1');
            $table->float('Misconduct_Days');
            $table->float('half_Gross_salary');
            $table->float('Sick_Leave_Social_Insurance');
            $table->float('Social_insurance_ER_share');
            $table->float('Medical_Insurance');
            $table->float('Life_Insurance');
            $table->float('Unpaid_Leave');
            $table->float('Unpaid_leave_half_Days');
            $table->float('Penalties');
            $table->float('Absence');
            $table->float('Absence_Penalty');
            $table->float('Unauthorized_Absence');
            $table->float('Lateness_between_1_and_60_minutes');
            $table->float('Lateness_between_60_and_120_minutes');
            $table->float('Lateness_between_120_and_beyond');
            $table->float('Missing_sign_in_out');
            $table->float('Early_out');
            $table->float('Misconduct_OTL');
            $table->float('CP_Penalties');
            $table->float('penalty_transfer');
            $table->float('Over_Time_Request');
            $table->float('Business_Trip_Overtime');
            $table->float('Business_Trip_Overtime_Holiday');
            $table->float('Holiday_Overtime');
            $table->float('Overtime_OTL');
            $table->float('loan_installment');
            $table->float('loan_capital_amount');
            $table->float('Loan_Value');
            $table->float('loan_comment');
            $table->float('Traffic_violations_installment');
            $table->float('Traffic_violations_capital_amount');
            $table->float('Traffic_violations_comment');
            $table->float('Martyrs_fund');
            $table->float('Diff_Start_Plus');
            $table->float('Diff_Start_minus');
            $table->float('Gross_Salary');
            $table->float('Insurance_salary');
            $table->float('Taxable_salary');
            $table->float('Total_Earnings');
            $table->float('Total_Deductions');
            $table->float('Net_Salary');
            $table->foreignIdFor(CiInstances::class, 'instance_id');
            $table->integer('payroll_id');
            $table->integer('period_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instances_run_values');
    }
};
