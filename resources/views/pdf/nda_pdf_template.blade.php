<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="css/main.css" />
</head>

<body>

<style>
    .nda-disclosure:not(.nda-agreement--popup-content) {
        max-width: 892px;
        padding: 0 15px;
        margin: auto;
    }
    .nda-disclosure ol ol {
        padding-left: 20px;
        padding-bottom: 20px;
    }
    .nda-disclosure ol {
        padding-bottom: 20px;
    }
    .nda-disclosure p,
    .nda-disclosure li {
        font-size: 14px;
        line-height: 16px;
    }
    .nda-disclosure p:not(:last-child),
    .nda-disclosure li:not(:last-child) {
        margin-bottom: 20px;
    }
    .nda-disclosure .title {
        margin-bottom: 50px;
        font-weight: 300;
        font-size: 24px;
        line-height: 28px;
        text-align: center;
    }
    .nda-disclosure .title-second {
        margin: 20px 0;
        font-size: 18px;
        font-weight: 300;

    }
    .nda-disclosure form input {
        width: max-content;
        min-width: 270px;
    }
</style>

<div class="nda-disclosure">
    <div class="nda-disclosure--popup-content">
        <form class="nda-disclosure__text nda-agreement__text">
            <div class="title">NON-DISCLOSURE AGREEMENT (NDA)</div>
            <p>
                This Non-Disclosure Agreement (the "Agreement") is made and entered into on
                <b>{{$insert_data}}</b>
                between
                <b>{{$name_of_project_owner_and_company_if_included}}</b>
                ("Disclosing Party")
                and
                <b>{{$name_of_the_investor}}</b>
                ("Receiving Party") (collectively, the "Parties").
            </p>
            <ol>
                <li>
                    1.	Definition of Confidential Information Confidential Information means any and all non-public,
                    proprietary, confidential, or trade secret information, whether in written, oral, electronic,
                    or any other form, that is disclosed by the Disclosing Party to the Receiving Party.
                </li>
                <li>
                    2.	Obligations of Receiving Party The Receiving Party agrees to:
                </li>
                <ol>
                    <li>
                        a. Protect Confidential Information: use its best efforts to maintain the confidentiality
                        of the Disclosing Party's Confidential Information and to prevent any unauthorized use
                        or disclosure of the Confidential Information;
                    </li>
                    <li>
                        b. Limited Use: use the Confidential Information solely for the purpose of
                        <b>{{$name_of_the_project}}</b>;
                    </li>
                    <li>
                        c. Limited Disclosure: disclose the Confidential Information only to those of its employees,
                        agents, or representatives who need to know the Confidential Information for the purpose
                        set forth in Section 2(b) above and who have signed a copy of this Agreement or are
                        otherwise bound by a similar obligation of confidentiality;
                    </li>
                    <li>
                        d. Return or Destroy: promptly return or destroy all copies of the Confidential
                        Information upon request of the Disclosing Party.
                    </li>
                </ol>
                <li>
                    3.	Exclusions The Receiving Party's obligations under this Agreement do not apply to information that:
                    <ol>
                        <li>
                            a. was rightfully in its possession or known to it prior to receipt from the Disclosing Party;
                        </li>
                        <li>
                            b. is or becomes publicly available through no fault of the Receiving Party;
                        </li>
                        <li>
                            c. is rightfully obtained by the Receiving Party from a third party without restriction as to use or disclosure;
                        </li>
                        <li>
                            d. is independently developed by the Receiving Party without reference to the Disclosing Party's Confidential Information;
                        </li>
                        <li>
                            e. is required to be disclosed by law or by a governmental authority, provided that the Receiving Party shall promptly
                            notify the Disclosing Party of such requirement and cooperate with the Disclosing Party in seeking a protective order
                            or other appropriate remedy.
                        </li>
                    </ol>
                </li>
                <li>
                    4.	Term and Termination This Agreement shall remain in effect for a period of <b>{{$insert_number}}</b>
                    years from the date of this Agreement, unless terminated earlier by mutual agreement of the Parties or by the Disclosing
                    Party upon written notice to the Receiving Party. The obligations of confidentiality and non-use contained in this
                    Agreement shall survive any termination of this Agreement.
                </li>
                <li>
                    5.	Governing Law and Jurisdiction This Agreement shall be governed by and construed in accordance with the laws of
                    <b>insert governing law and jurisdiction</b>, and any dispute arising under this Agreement
                    shall be resolved exclusively by the courts of <b>{{$country}}</b>.
                </li>
                <li>
                    6.	Entire Agreement This Agreement constitutes the entire understanding between the Parties with respect to the subject
                    matter hereof and supersedes all prior discussions, negotiations, and agreements between the Parties, whether
                    written or oral.
                </li>
            </ol>
            <p class="title-second">
                IN WITNESS WHEREOF, the Parties have executed this Agreement as of the date first above written.
            </p>
            <p>
                <img class="nda-info__signature-field" style="width: 300px; height: 69px;" width="300" height="69" src="{{ $signature_owner }}">
            </p>
            <p style="margin-top: 50px;">
                <img class="nda-info__signature-field" style="width: 300px; height: 69px;" width="300" height="69" src="{{ $signature }}">
            </p>
        </form>
    </div>
</div>


</body>

</html>
